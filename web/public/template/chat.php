<?php
require '_header.php';
$userReceivers = $_COOKIE['receivers'];
$user = $_COOKIE['login'];
$receiver = $_COOKIE['receiver'];
$newChat = false;
// check user and receiver
if ($user=='' || $receiver=='') exit;
$time = time();
$checkUsersInTable = select("SELECT * FROM `chats_id` WHERE user1='$user' && user2='$receiver' || user1='$receiver' && user2='$user'");
$getLastChatID = select("SELECT id FROM `chats_id` ORDER BY id DESC LIMIT 1")[0]['id'] + 1 ?? 1;
$tableName;
$chat;
echo 1;
// create new table if it doesnt exist
if (count($checkUsersInTable) == 0) {
    $newChat = true;
    $tableName = 'chat_'.$getLastChatID;
    $chat = "<div class='chat__new'><p>Это начало переписки с $receiver</p></div>";
}
else {
    // load chat
    $tableName = 'chat_'.$checkUsersInTable[0]['id'];
    $getChat = select("SELECT * FROM $tableName WHERE `is_seen`=0");
    $chatCount = count($getChat);
    
    if ($chatCount == 0) {
        $getChat = array_reverse(select("SELECT * FROM `$tableName` ORDER BY `id` DESC LIMIT 20"));
        $startID = $getChat[0]['id'] - 1;
    }
    else {
        $startID = $getChat[0]['id'] - 1;
        $getLoadedChat = array_reverse(select("SELECT * FROM $tableName WHERE id <= $startID ORDER BY id DESC LIMIT 20"));
        $newMessagesBreak = [
            'type' => 'new_messages'
        ];
        $getChat = array_merge($getLoadedChat, $newMessagesBreak, $getChat);
        $startID = $getLoadedChat[0]['id'] - 1;
    }
    $getLastMessageTime = end($getChat)['time'];

    // update is_seen
    execQuery("UPDATE `$tableName` SET `is_seen`= 1 WHERE `receiver`='$user' AND `is_seen`=0");

    foreach($getChat as $key => $item) {
        // if new messages
        if ($key == 'type' && $item == 'new_messages') {
            $chat.="<div class='chat__new-date'><span>новые сообщения</span></div>";
            continue;
        }
        // create html message
        $messageHours = date("H:i" ,$item['time']);
        $messageDate = date("d.m", $item['time']);
        $previousMessageTime = date("H:i", $getChat[$key - 1]['time']);
        $previousDate = date("d.m", $getChat[$key - 1]['time']);
    
        // if different days
        if ($messageDate != $previousDate) {
            $chat.="<div class='chat__new-date'><span>$messageDate</span></div>";
        }
    
        $message = "<div class='chat__message";
        if ($item['sender'] == $user) $message .= " right'>";
        else $message .= " left'>";
        
        // message type logic
        $messageContent = '';
        if (substr($item['message'], 0, 6) == 'image:') {
            $imgPath = substr($item['message'], 7, strlen($item['message']));
            $messageContent = "<div class='img__block'><div class='img'><img src='$imgPath'></div></div>";
        } else if (substr($item['message'], 0, 6) == 'voice:') {
            // display audio in js
            $voicePath = substr($item['message'], 7, strlen($item['message']));
            $messageContent = "<div class='voice__block unknown-length'><div class='voice__el' path='$voicePath'><audio controls ><source src='$voicePath' type='audio/wav'></audio></div></div>";
        } else {
            $messageContent = "<div class='message__block'><p>$item[message]</p></div>";
        }
    
        if ($messageHours == $previousMessageTime) {
            $message .= $messageContent.'</div>';
        } else {
            $message .= "<span>$messageHours</span>$messageContent</div>";
        }
    
        $chat.=$message;
    }
}
?>

<div class="chat">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?=$chat?>
            </div>
        </div>
    </div>
</div>

<!-- send message -->
<div class="chat-send">
    <div class="container">
        <div class="row">
            <div class="col-12 chat-send__form">
                <div class="chat__text">
                    <span class='message-area' contentEditable></span>
                    <div class='message-send'><img src="img/send-message.png" alt=""></div>
                </div>
                <div class="chat__media">
                    <input type="file" multiple accept="image/*" id="f" class="file__inp">
                    <label class='images' for="f"><img src="img/image-icon.png" alt=""></label>
                    
                    <div class="voice__length hidden">00:00</div>
                    <div class="voice">
                        <div class="voice__on"><img src="img/micro-icon.png" alt=""></div>
                        <div class="voice__off hidden"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type='module'>
import {checkIcons} from '../js/checkIcon.js';
let icons = document.querySelectorAll('#icon-img');
checkIcons(icons);

let sendBtn = document.querySelector('.message-send');
let messageField = document.querySelector('.message-area');
let chat = document.querySelector('.chat');
let chatMessages = chat.querySelector('.col-12');
let table = '<?=$tableName?>';
let sentMessageTime = [];
let voiceTimer;
let inp = document.querySelector('.file__inp');
let chatBlock = document.querySelector('.chat');
let voiceLength = document.querySelector('.voice__length');
let min, sec, addMethod;

// get audio length
let allAudio = chatMessages.querySelectorAll('.unknown-length audio');
allAudio.forEach(el => {
    getAudioLength(el);
})

// voice
let voiceStart = document.querySelector('.voice__on');
let voiceStop = document.querySelector('.voice__off');

navigator.mediaDevices.getUserMedia({ audio: true})
    .then(stream => {
        const mediaRecorder = new MediaRecorder(stream);
        let voice = [];
        voiceStart.addEventListener('click', function(){
            document.cookie = "table=<?=$tableName?>; expires=0; path=/";
            voiceStop.classList.remove('hidden');
            voiceLength.classList.remove('hidden');
            mediaRecorder.start();
            getVoiceLength();
        });

        mediaRecorder.addEventListener("dataavailable",function(event) {
            voice.push(event.data);
        });

        voiceStop.addEventListener('click', function(){
            mediaRecorder.stop();
            voiceStop.classList.add('hidden');
            voiceLength.classList.add('hidden');
            stopVoiceLength();
        });

        mediaRecorder.addEventListener("stop", function() {
            let voiceBlob = new Blob(voice, {
                type: 'audio/wav'
            });

            let fd = new FormData();
            fd.append('voice', voiceBlob);
            fetch('./ajax/send_voice.php', {
                method: 'POST',
                body: fd
            })
            .then(data => data.json())
            .then(data => {
                let timeData = checkDate(true);
                    timeData.path = data['data'];
                addSoundBar(timeData);
                scrollToTheBottom();
                voice = [];
                // send to server
                sendRequest(`voice:${data['data']}`, table)
                document.cookie = "table=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            })
        })
    });
    

// new chat
;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    document.addEventListener(eventName, preventDefaults, false)
  })
  let isNewChat = '<?=$newChat?>';
if (isNewChat == 1) {
    sendBtn.addEventListener('click', (e) => uploadNewChat(e, 'text'));
    document.addEventListener('drop', (e) => {
        let files = e.dataTransfer.files;
        uploadNewChat(files, 'img-drag')
    });
    inp.onchange = (e) => {
        uploadNewChat(e, 'img-choose')
    }
    voiceStop.addEventListener('click', (e) => uploadNewChat(e, 'audio'))
}
else {
    // add events
    messageField.onfocus = (e) => window.addEventListener('keydown', sendByKey);
    messageField.onblur = (e) => window.removeEventListener('keydown', sendByKey);
    sendBtn.addEventListener('click', send);
    document.addEventListener('drop', (e) => {
        let files = e.dataTransfer.files;
        sendImg(files);
    }, false)
    inp.onchange = (e) => {
        let files = e.target.files;
        handleFiles(files);
    }
}


window.onload = () => {
        // scroll to bottom of the chat
    chatMessages.scrollTop = chatMessages.scrollHeight;
}


// check new messages
checkMessages();


document.addEventListener('scroll', loadMessages);
document.addEventListener('wheel', loadMessages);

let startID = '<?=$startID?>';
function loadMessages(e) {
    if (isNewChat != '') return false;
    if (pageYOffset < 300 && e.deltaY < 0) {
        // remove event
        document.removeEventListener('scroll', loadMessages);
        document.removeEventListener('wheel', loadMessages);
        // add event
        setTimeout(() => {
            document.addEventListener('scroll', loadMessages);
            document.addEventListener('wheel', loadMessages);
        }, 1000);


        fetch('./ajax/get_chat_messages.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({"start_id": startID,"table": table}),
        })
        .then(data => data.json())
        .then(data => {
            if (data.length == 0) return;
            startID = +data[data.length - 1]['id'] - 1;

            // add messages into page
            data.forEach((el, key) => {
                let message = el['message'];

                // time
                let currentMessageTime = el['time'];
                    currentMessageTime = `${("0" + ((new Date(currentMessageTime * 1000)).getHours())).slice(-2)}:${("0" + ((new Date(currentMessageTime * 1000)).getMinutes())).slice(-2)}`
                let prevMessageTime;
                try {
                    prevMessageTime = data[key+1]['time'];
                    prevMessageTime = `${("0" + ((new Date(prevMessageTime * 1000)).getHours())).slice(-2)}:${("0" + ((new Date(prevMessageTime * 1000)).getMinutes())).slice(-2)}`
                } catch(e) {
                    prevMessageTime = currentMessageTime;
                }

                let currentDate = el['time'];
                    currentDate = `${("0" + ((new Date(currentDate * 1000)).getDate())).slice(-2)}.${("0" + ((new Date(currentDate * 1000)).getMonth()+1)).slice(-2)}`
                let messageDate;
                try {
                    messageDate = data[key+1]['time'];
                    messageDate = `${("0" + ((new Date(messageDate * 1000)).getDate())).slice(-2)}.${("0" + ((new Date(messageDate * 1000)).getMonth()+1)).slice(-2)}`
                } catch(e) {
                    prevMessageTime = currentMessageTime;
                }
                addNewTime(currentDate, messageDate, addMethod='prepend');

                // handle message
                let timeData = {
                    time: currentMessageTime,
                    lastTime: prevMessageTime,
                    sender: el.sender
                };
                
                if (message.substring(0, 6) == 'image:') { // img
                    timeData.src = message.substring(7);
                    drawImg(timeData, addMethod='prepend');
                }
                else if (message.substring(0, 6) == 'voice:') { //voice
                    timeData.path = message.substring(7);
                    addSoundBar(timeData, addMethod='prepend')
                }
                else { //text
                    timeData.message = message;
                    drawTextMessage(timeData, 'prepend');
                }
            })
        })
    }
}

function checkMessages () {
    setTimeout(() => {
        // check database
        let receiver = '<?=$receiver?>';
        fetch('../ajax/check_new_messages.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({"table": table, "receiver":receiver}),
        })
        .then(data => data.json())
        .then(data => {
            // handle message
            if (data == null) return false;
            let messageData = checkDate(false, data);
            let type = messageData.message.split(':');

            if (type[0] == 'image') {
                let message = document.createElement('div');
                addTime(message);
                let imgBlock = document.createElement('div');
                    imgBlock.classList.add('img__block');
                let imgBlock2 = document.createElement('div');
                    imgBlock2.classList.add('img');
                let messageImg = document.createElement('img');
                    messageImg.src = type[1];
                    imgBlock2.append(messageImg);
                    imgBlock.append(imgBlock2);
                    message.append(imgBlock);
                    chatMessages.append(message);
            }
            else if (type[0] == 'voice') {
                let message = document.createElement('div');
                addTime(message);

                let voiceBlock = document.createElement('div');
                    voiceBlock.classList.add('voice__block');
                let voice = document.createElement('div');
                    voice.classList.add('voice__el');
                    voice.setAttribute('path', type[1]);
                let voiceBlock2 = document.createElement('audio');
                    voiceBlock2.setAttribute('crossorigin', true);
                    voiceBlock2.controls = true;
                    voiceBlock2.setAttribute('preload', 'true');
                let messageVoice = document.createElement('source');
                    messageVoice.src = type[1];
                    messageVoice.type="audio/mp3";

                    voiceBlock2.append(messageVoice);
                    voice.append(voiceBlock2);
                    voiceBlock.append(voice);
                    message.append(voiceBlock);
                    chatMessages.append(message);

                    let vid = chatMessages.querySelector(`.voice__el[path="${type[1]}"] > audio`);
                    getAudioLength(vid);
            }
            else {
                let message = document.createElement('div');
                // add text message in html
                addTime(message);
                let messageBlock = document.createElement('div');
                    messageBlock.classList.add('message__block');
                let messageText = document.createElement('p');
                    messageText.innerHTML = messageData['message'];
                    messageBlock.append(messageText);
                    message.append(messageBlock);
                    chatMessages.append(message);
            }

            scrollToTheBottom();

            function addTime(message) {
                message.classList.add('chat__message','left');
                let messageTime = document.createElement('span');
                messageTime.innerHTML = messageData['time'];
                if (messageData['time'] != messageData['lastTime']) message.append(messageTime);
            }
        })
        .catch(e => {})

        checkMessages()
    }, 1000);
}

function uploadNewChat (e, contentType) {
    if (sendBtn.dataset.chatUploaded == true || document.body.classList.contains('dropChatUpload') || inp.dataset.chatUploaded == true || voiceStop.classList.contains('chatUploaded')) {
        if (contentType == 'text') send();
        else if (contentType == 'img-drag') sendImg(e);
        else if (contentType == 'img-choose') handleFiles(e.target.files);

        return false;
    }

    voiceStop.classList.add('chatUploaded');
    document.body.classList.add('dropChatUpload');
    sendBtn.dataset.chatUploaded = true;
    inp.dataset.chatUploaded = true;

    let data = {
        "user": '<?=$user?>',
        "receiver": '<?=$receiver?>',
        "table": '<?=$tableName?>',
        "receivers": '<?=$userReceivers?>',
    }

    fetch('./ajax/upload_table.php', {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data),
    })
    .then(() => {
        // send message depending on its type
        if (contentType == 'text') send();
        else if (contentType == 'img-drag') sendImg(e);
        else if (contentType == 'img-choose') handleFiles(e.target.files);
    })

    document.cookie = "newChat="+'<?=$tableName?>'+"; expires=0; path=/"
}

function sendByKey(e) {
    if (e.code == 'Enter') {
        e.preventDefault();
        send();
    }
}

function preventDefaults (e) {
    e.preventDefault()
    e.stopPropagation()
}

function sendImg (files) {
    handleFiles(files)
}

function handleFiles(files) {
    ([...files]).forEach(uploadFile)
}

function uploadFile(file) {
    document.cookie = "table=<?=$tableName?>; expires=0; path=/";
    let reader = new FileReader()
    reader.readAsDataURL(file)
    reader.onloadend = () => {
        let imgBASE64 = reader.result;
        let data = checkDate(true);
            data.src = imgBASE64;

        // draw img
        drawImg(data, addMethod='append');
        scrollToTheBottom();
        
        // add img to directory
        let url = './ajax/send_image.php';
        let formData = new FormData()
        formData.append('file', file)
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then((data) => data.text())
        .then(data => {
            sendRequest(`image:${data}`, table)
            document.cookie = "table=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        })
    }
}

function send() {
    let data = checkDate();
    if (!data) return;

    // add message in html
    drawTextMessage(data);
    scrollToTheBottom();

    // send message
    sendRequest(data['message'], table);
}

function checkDate(isMedia = false, newMessage = false) {
    let messageContent;

    if (newMessage) {
        messageContent = newMessage[0];
    }
    else messageContent = messageField.textContent.trim();
    
    // check empty
    if (messageContent == '' && !isMedia) return false;
    let currentDate = '<?=date("d.m")?>';
    let h = new Date().getHours();
    let m = new Date().getMinutes();
    if (h < 10) h = '0'+h;
    if (m < 10) m = '0'+m;
    let time = `${h}:${m}`;
    let getMessageTime = '<?=$getLastMessageTime?>';
    let lastTime = sentMessageTime[1] ?? `${new Date(getMessageTime * 1000).getHours()}:${new Date(getMessageTime * 1000).getMinutes()}`;
    let messageDate = sentMessageTime[0] ?? '<?=date("d.m",$getLastMessageTime)?>';
    sentMessageTime = [currentDate, time];

    messageField.textContent = '';

    // check date
    addNewTime(currentDate, messageDate);

    return {
        'time': time,
        'lastTime': lastTime,
        'message': messageContent ?? 'media',
        'sender': '<?=$user?>'
    };
}

function sendRequest(message, table) {
    fetch('../template/send_message.php', {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({"message": message,"table": table}),
    })
}

function scrollToTheBottom() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: "smooth",
        transition: .3
    })
}

function addSoundBar(data, addMethod='append') {
    let path = data['path'];
    let sender = data.sender;

    // draw voice
    let message = document.createElement('div');
    let messagePos = checkUser(sender);
    
        message.classList.add('chat__message', messagePos);
    let messageTime = document.createElement('span');
        messageTime.innerHTML = data['time'];
    if (data['time'] != data['lastTime']) message.append(messageTime);

    let voiceBlock = document.createElement('div');
        voiceBlock.classList.add('voice__block');
    let voice = document.createElement('div');
        voice.classList.add('voice__el');
        voice.setAttribute('path', path);
    let voiceBlock2 = document.createElement('audio');
        voiceBlock2.setAttribute('crossorigin', true);
        voiceBlock2.setAttribute('preload', true);
        voiceBlock2.controls = true;
    let messageVoice = document.createElement('source');
        messageVoice.src = path;
        messageVoice.type="audio/wav";

        voiceBlock2.append(messageVoice);
        voice.append(voiceBlock2);
        voiceBlock.append(voice);
        message.append(voiceBlock);

        if (addMethod == 'append') {
            chatMessages.append(message);
        } else if (addMethod == 'prepend') {
            chatMessages.prepend(message);
        }

        let vid = chatMessages.querySelector(`.voice__el[path="${path}"] > audio`);
        getAudioLength(vid);
}

function drawImg(data, addMethod) {
    let src = data.src;
    let sender = data.sender;
    
    let message = document.createElement('div');
    let messagePos = checkUser(sender);

        message.classList.add('chat__message', messagePos);
    let messageTime = document.createElement('span');
        messageTime.innerHTML = data['time'];
    if (data['time'] != data['lastTime']) message.append(messageTime);
    let imgBlock = document.createElement('div');
        imgBlock.classList.add('img__block');
    let imgBlock2 = document.createElement('div');
        imgBlock2.classList.add('img');
    let messageImg = document.createElement('img');
        messageImg.src = src;
        imgBlock2.append(messageImg);
        imgBlock.append(imgBlock2);
        message.append(imgBlock);
        
    if (addMethod == 'append') {
        chatMessages.append(message);
    } else if (addMethod == 'prepend') {
        chatMessages.prepend(message);
    }
}

function drawTextMessage(data, addMethod='append') {
    let sender = data.sender;

    let message = document.createElement('div');
    let messagePos = checkUser(sender);

        message.classList.add('chat__message', messagePos);
    let messageTime = document.createElement('span');
        messageTime.innerHTML = data['time'];
    if (data['time'] != data['lastTime']) message.append(messageTime);
    let messageBlock = document.createElement('div');
        messageBlock.classList.add('message__block');
    let messageText = document.createElement('p');
        messageText.innerHTML = data['message'];
        messageBlock.append(messageText);
        message.append(messageBlock);
        
    if (addMethod == 'append') {
        chatMessages.append(message);
    } else if (addMethod == 'prepend') {
        chatMessages.prepend(message);
    }
}

function addNewTime(currentDate, messageDate, addMethod='append') {
    if (currentDate != messageDate) {
        let dateBlock = document.createElement('div');
            dateBlock.classList.add('chat__new-date');
        let dateSpan = document.createElement('span');
            dateSpan.innerHTML = currentDate;
        dateBlock.append(dateSpan);
        
        if (addMethod == 'append') {
            chatMessages.append(dateBlock);
        } else if (addMethod == 'prepend') {
            chatMessages.prepend(dateBlock);
        }
    }
}

function checkUser(sender) {
    if (sender == '<?=$user?>') {
        return 'right';
    } else {
        return 'left';
    }
}

function getVoiceLength() {
     min = 0;
    sec = 0;
    voiceTimer = setInterval(tick, 1000);
}

function stopVoiceLength() {
    clearInterval(voiceTimer);
    voiceLength.innerHTML = '00:00';
}

function tick() {
    sec++;
    if (min >= 60) { //задаем числовые параметры, меняющиеся по ходу работы программы
        min++;
        sec = sec - 60;
    }
    if (sec >= 30) {
        voiceStop.click();
        stopVoiceLength();
        return;
    }
    if (sec < 10) { //Визуальное оформление
        if (min < 10) {
            voiceLength.innerHTML = '0' + min + ':0' + sec;
        } else {
            voiceLength.innerHTML = min + ':0' + sec;
        }
    } else {
        if (min < 10) {
            voiceLength.innerHTML = '0' + min + ':' + sec;
        } else {
            voiceLength.innerHTML = min + ':' + sec;
        }
    }
}

function getAudioLength(vid) {
    vid.addEventListener('loadedmetadata', function () {
        if (vid.duration == Infinity) {
            vid.classList.remove('unknown-length');
            vid.currentTime = 1e101;
            vid.ontimeupdate = function () {
                this.ontimeupdate = () => {
                    return;
                }
                vid.currentTime = 0;
                return;
            }
        }
    });
}


</script>
