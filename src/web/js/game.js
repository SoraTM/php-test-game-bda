$(document).ready(function() {
    $('body').on("click", "#start-game", (function () {
        var diceCount = getCookie('gameState[diceCount]');
        if(diceCount > 0){
            $("#start-game").prop( "disabled", true );
            $("#dice-score").removeClass();
            var diceScore = getDiceScore(1, 6);
            animateDice(12, 80).then(
                () => showDice(diceScore)).then(
                    () => $.getJSON("/?stepsToNextPoint=" + diceScore)).then(
                        (data) => animatePimpa(data)).then(
                            () => ajaxRefreshPage(diceScore));
        } else {
            alert('Game over!');
        }
    }));

    $('body').on("click", "#reset-game", (function () {
        deleteCookies();
        location.reload();
    }));
});

function animateDice(i, positionOffset){
    return new Promise((resolve, reject) => {
        function animate(i, positionOffset) {
            setTimeout(function() {
                $( ".dices .dice" ).last().css( "background-position", '-' + positionOffset + 'px' );
                positionOffset += 77;
                if(i > 0){
                    animate(i - 1, positionOffset);
                } else {
                    resolve(true);
                }
            }, 100);
        }
        animate(i, positionOffset);
    });
}

function animatePimpa(route){
    return new Promise((resolve, reject) => {
        function animate(route) {
            setTimeout(function() {
                $( "#pimpa" ).removeClass().addClass(route.pop());
                if(route.length > 0){
                    animate(route);
                } else {
                    resolve(true);
                }
            }, 600);
        }
        animate(route.reverse());
    });
}

function showDice(diceScore){
    return new Promise((resolve, reject) => {
        function show(diceScore) {
            $("#dice-score").removeClass().addClass("dice-score-" + diceScore);
            resolve(true);
        }
        show(diceScore);
    });
}

function ajaxRefreshPage(diceScore){
    $.ajax({
        url: "/",
        cache: false,
        type: "POST",
        data: "diceScore=" + diceScore,
        dataType: "text",
        success: function (data) {
            var result = $(data).filter('.court').html();
            $('.court').html(result);
        }
    });
}

function getDiceScore(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

/* COOKIES FUNCTIONS */

function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function deleteCookies() {
    setCookie('gameState[diceScore]', "", {
        expires: -1
    })
    setCookie('gameState[stepScore]', "", {
        expires: -1
    })
    setCookie('gameState[totalScore]', "", {
        expires: -1
    })
    setCookie('gameState[position]', "", {
        expires: -1
    })
    setCookie('gameState[diceCount]', "", {
        expires: -1
    })
}
