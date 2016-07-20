$( document ).ready(function() {

    $('body').on("click", "#start-game", (function () {
        var diceCount = getCookie('gameState[diceCount]');
        console.log('clicked' + diceCount);
        if(diceCount > 0){
            var promise = new Promise(function(resolve, reject) {
                var result = animateDice(12, 80);
                console.log()
                if(result){
                    resolve();
                } else {
                    reject();
                }
            });

            promise.then(() => ajaxRefreshPage(), () => console.log('error'));

        } else {
            alert('Game over!')
        }
    }));

    $('body').on("click", "#reset-game", (function () {
        console.log('clicked del');
        deleteCookies();
        location.reload();
    }));

});

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

function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min);
}

function animateDice(i, positionOffset){
        setTimeout(function() {
            $( ".dices .dice" ).last().css( "background-position", '-' + positionOffset + 'px' );
            positionOffset += 77;
            if(i > 0){
                return animateDice(i - 1, positionOffset);
            } else {
                console.log('true');
                return true;
            }
        }, 100);
}

function ajaxRefreshPage(){
    var diceScore = getRandomInt(1, 6);
    $.ajax({
        url: "index.php",
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
