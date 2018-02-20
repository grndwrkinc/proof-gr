//*****************************************************************
//* FluidVids.js - Fluid and Responsive YouTube/Vimeo Videos v1.0.0 by 
//* Todd Motto: http://www.toddmotto.com
//* Latest version: https://github.com/toddmotto/fluidvids
//* 
//* Copyright 2013 Todd Motto
//* Licensed under the MIT license
//* http://www.opensource.org/licenses/mit-license.php
//* 
//* A raw JavaScript alternative to FitVids.js, fluid width video embeds
//* 
function fluidVids() {
    var iframes = document.getElementsByTagName('iframe');

    for (var i = 0; i < iframes.length; i++) {
        var iframe = iframes[i];
        var players = /www.youtube.com|player.vimeo.com/;

        var iframeSrc = iframe.src;
        iframe.src = "";

        if(iframeSrc.search(players) !== -1) {
            var videoRatio = (iframe.height / iframe.width) * 100;

            iframe.style.position = 'absolute';
            iframe.style.top = '0';
            iframe.style.left = '0';
            iframe.width = '100%';
            iframe.height = '100%';

            var div = document.createElement('div');
            div.className = 'video-wrap';
            div.style.width = '100%';
            div.style.position = 'relative';
            div.style.paddingTop = videoRatio + '%';

            var parentNode = iframe.parentNode;
            parentNode.insertBefore(div, iframe);
            div.appendChild(iframe);

            // Added the following code to add wmode=transparent to the 
            // end of youtube embeds to ensure they don't break 
            // z-indexing.
            var wmode = "wmode=transparent";

            if(iframeSrc.indexOf('youtube') !== -1) {
                if(iframeSrc.indexOf('?') !== -1) {
                    var getQString = iframeSrc.split('?');
                    var oldString = getQString[1];
                    var newString = getQString[0];
                    
                    iframeSrc = newString+'?'+wmode+'&'+oldString;
                }
                else {
                    iframeSrc = iframeSrc + '?' + wmode;
                }
            }

            iframe.src = iframeSrc;
        }
    }
}