<?php
require_once '_header.php';
// check login

$login = $_COOKIE['login'];
$user_receivers = select("SELECT chat_id FROM users WHERE userName = '$login'")[0]['chat_id'];
$out = '';

if ($user_receivers[0] != '0') {
    $date = time();
    $data = explode(",", $user_receivers);
    foreach($data as $item) {
        $tableName = 'chat_'.$item;
        $chat = select("SELECT `sender`,`receiver` FROM `$tableName` WHERE `id`=1")[0];
        $user;
        if ($chat['sender'] == $login) $user = $chat['receiver'];
        else if ($chat['receiver'] == $login) $user = $chat['sender'];

        // TIME
        $userData = select("SELECT `online` FROM users WHERE `userName`='$user'");
        $lastTimeOnline = "<p>В сети: ";
        $userTime = $date - $userData[0]['online'];
    
        if ($userTime < 60) $lastTimeOnline .= 'только что</p>';
        else if ($userTime < 3600) $lastTimeOnline.=round($userTime/60).' мин. назад</p>';
        else if ($userTime < 3600*24) $lastTimeOnline.=round($userTime/3600).' ч. назад</p>';
        else if ($userTime < 3600*24*31) $lastTimeOnline.=round($userTime/3600/24).' д. назад</p>';
        else if ($userTime == $date) $lastTimeOnline = '<p class="online">В сети</p>';
        else if ($userTime >= 3600*24*31) $lastTimeOnline.=' давно</p>';
        $improvedUsername = trim($user);
        $out .= "
            <div class='user' data-chat-id='$item'>
                <div class='chat__user-text'>
                    <img src='../images/user_icons/$user.jpeg' id='icon-img'>
                    <span>$user</span>
                    $lastTimeOnline
                </div>
                <div class='chat__new-messages'></div>
                <a href='/chat' onclick=document.cookie='receiver=$improvedUsername;expires=0'>Написать</a>
            </div>
        ";
    }
}
?>

<div class="container">
    <div class="row users">
        <?=$out?>
    </div>
</div>


<script type='module'>
import {checkIcons} from '../js/checkIcon.js';
let icons = document.querySelectorAll('#icon-img');
checkIcons(icons);


let inp = document.querySelector('.navbar__search input');
let hintBlock = document.querySelector('.navbar__search-output')
let usersContainer = document.querySelector('.users');
let id = 1;
let inpVal;
let timer;

// check new messages
checkMessages();

document.addEventListener("visibilitychange", function(){
	if (!document.hidden){
		restartGettingMessages()
	}
});

document.addEventListener('click', hideSearchHint);
function hideSearchHint(e) {
    if (!e.target.classList.contains('search__result') || !e.target.tagName == 'input') hintBlock.innerHTML = ''
}

inp.onfocus = () => id = 1;
inp.onblur = () => inp.value = '';
inp.onkeydown = (e) => {
    hintBlock.innerHTML = ''
    let key = e.key;

    key.length > 1? inpVal = inp.value: inpVal = inp.value + key;
    if (key.length > 1) {
        inpVal = inp.value.trim();

        if (inpVal.length == 0) return false;
    }
    else {
        inpVal = inp.value.trim() + key;
    }
    if (key == 'Backspace') {
        inpVal = inpVal.substr(0,inpVal.length - 1);

        if (inpVal.length == 0) {
            hintBlock.innerHTML = ''
            inp.value = ''

            return false;
        }
    }
    id = 1;
    getMatches(id,inpVal);
}

// hide message count after link is clicked
usersContainer.addEventListener('click', hideMessageCount);

// hint block onscroll add data
hintBlock.addEventListener('scroll', () => addMatches(id,inpVal));

function restartGettingMessages() {
    document.cookie = 'receiver=; Max-Age=0; path=/;';
    clearTimeout(timer);
    checkMessages()
}

function getMatches(id,inp) {
    // get matches from database
    fetch('./template/get_search_matches.php', {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "startID": id,
            "str": inp
        })
    })
    .then(data => data.json())
    .then(data => {
        drawHint(data);
    })
}

function drawHint(data) {
    // startID = last element from database
    if (data.length == 0) return false;
    id = +data[data.length-1]['id'] + 1;
    // add search res
    for (let key in data) {
        let item = data[key];
        let out = '';
        if (item['userName'].includes(inpVal)) {
            out = item['userName'].replace(inpVal, '<mark>'+inpVal+'</mark>')
            hintBlock.innerHTML += `<a href='chat' data-id='${key}' class="search__result">${out}</a>`;
        }
    }

    hintBlock.onclick = function(e) {
        let key = e.target.dataset.id;
        let user = data[+key];
        let name = user.userName;
        let id = user.id;

        setReceiver(name, id);
    }
}

function addMatches(id,inp) {
    if (hintBlock.scrollHeight - hintBlock.scrollTop === hintBlock.clientHeight) {
        getMatches(id,inp);
    }
}

function setReceiver(receiver,id) {
    // add receiver id to table cell
    let receivers = '<?=$user_receivers?>';

    document.cookie = "receiver="+receiver+"; expires=0; path=/"
    document.cookie = "receivers="+receivers+"; expires=0; path=/"
}


function checkMessages() {
    timer = setTimeout(async() => {
        let login = '<?=$login?>';

        // get new receivers list
        let receivers = await fetch('../ajax/get_receivers.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({"login": login})
        })
        .then(data => data.text())

        await fetch('./ajax/get_messages.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({"message": receivers,"login": login}),
        })
        .then(data => data.json())
        .then(data => {
            data.forEach(item => {
                let messageCount = item[0];
                
                if (messageCount > 0) {
                    let tableID = +item[1];

                    // check new writer
                    let writer = document.querySelector(`.user[data-chat-id='${tableID}'] > .chat__new-messages`);
                    if (writer == null) {
                        fetch('./ajax/request_new_chat.php', {
                            method: "POST",
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "chat": 'chat_'+tableID,
                                "user": login,
                            })
                        })
                        .then(data => data.json())
                        .then(data => {
                            console.log(data);
                            let user = document.createElement('div');
                            user.classList.add('user');
                            user.dataset.chatId = tableID;
                            let div = document.createElement('div');
                                div.classList.add('chat__user-text');
                            let icon = document.createElement('img');
                                icon.src = '../images/'+data['receiver']+'.jpeg';
                                icon.id = 'icon-img';
                            let span = document.createElement('span');
                                span.innerHTML = data['receiver'];
                            let p = document.createElement('p');
                                p.innerHTML = data['time'];
                            let newMessages = document.createElement('div');
                                newMessages.classList.add('chat__new-messages');
                            div.append(icon);
                            div.append(span)
                            div.append(p)
                            let a = document.createElement('a');
                                a.innerHTML = 'Написать';
                                a.href = '/chat';
                                a.onclick = () => {
                                    document.cookie = `receiver=${data['receiver']};expires=0`;
                                }
                            user.append(div);
                            user.append(newMessages);
                            user.append(a);
                            usersContainer.prepend(user);

                            let icons = document.querySelectorAll('#icon-img');
                            checkIcons(icons);

                            if (messageCount > 9) messageCount = '9+';
                            user = usersContainer.querySelector(`.user[data-chat-id='${tableID}'] > .chat__new-messages`);
                            user.innerHTML = '<span>'+messageCount+'</span>';
                        })
                    }
                    else {
                        if (messageCount > 9) messageCount = '9+';
                        let user = usersContainer.querySelector(`.user[data-chat-id='${tableID}'] > .chat__new-messages`);
                        user.innerHTML = '<span>'+messageCount+'</span>';

                        // move chat up
                        let chat = usersContainer.querySelector(`.user[data-chat-id='${tableID}']`);
                        usersContainer.insertBefore(chat, usersContainer.firstChild)
                    }
                }
            });
        })
        
        checkMessages();
    }, 1000);
}

function hideMessageCount(e) {
    if (e.target.tagName == 'A') {
        let count = e.target.previousElementSibling;
        count.innerHTML = '';
    }
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}


</script>