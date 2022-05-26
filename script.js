
                function fallbackCopyTextToClipboard(text) {
                var textArea = document.getElementById("link");
                textArea.value = text;
        
                textArea.focus();
                textArea.select();
        
                document.execCommand('copy');
            }
            function copyTextToClipboard(text) {
                if (!navigator.clipboard) {
                fallbackCopyTextToClipboard(text);
                return;
            }
            navigator.clipboard.writeText(text)
        }
        
        document.getElementById('command').innerHTML = loadFile("https://pmmpinstaller.cf/command.txt");
        document.getElementById('tooltip').classList.remove('tooltiphover');
        document.getElementById('copybutton').onclick = function () {
            copyTextToClipboard(loadFile("https://pmmpinstaller.cf/command.txt"));
            document.getElementById('copybutton').src = "success-button.svg";
            document.getElementById('tooltip').classList.add('tooltiphover');
        }
        document.getElementById('copybutton').onmouseover = function () {
            document.getElementById('copybutton').src = "copy-button.svg";
            document.getElementById('tooltip').classList.remove('tooltiphover');
        }

        var tooltipSpan = document.getElementById('tooltip-span');
        tooltipSpan.style.visibility = "hidden" 
window.onmousemove = function (e) {
    tooltipSpan.style.left = e.clientX + 'px';
    tooltipSpan.style.top = e.clientY + 'px';
    tooltipSpan.style.visibility = "visible"
};

    document.getElementById('downloadedtimes').src = "https://img.shields.io/badge/downloads-"+String(JSON.parse(loadFile("https://api.countapi.xyz/get/pmmpinstaller.cf/5b01a783-a15f-4aa3-a534-36cc79988fe3")).value)+"-green";
    document.getElementById('version').src = "https://img.shields.io/badge/version-"+String(JSON.parse(loadFile("https://raw.githubusercontent.com/tpguy825/PMMPInstaller/main/version.json")).version)+"-lightblue";

function loadFile(filePath) {
  var result = null;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET", filePath, false);
  xmlhttp.send();
  if (xmlhttp.status==200) {
    result = xmlhttp.response;
  }
  return result;
}
