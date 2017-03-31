var ajax = function (url, data) {
    var req = new XMLHttpRequest();
    req.open('POST', url, true);
    req.onreadystatechange = function (aEvt) {
        if (req.readyState == 4) {
            if (req.status == 200) {
                console.log(req.response);
                document.querySelector('.webform .response').innerHTML = req.response;
            }
            else {
                console.log(req.response);
            }
        }
    };
    req.send(data)
};
var form = document.querySelector(".webform form");
if (form !== undefined && form != null) {
    var url = form.getAttribute("action");
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(form);
        ajax(url, formData);
    }, false);
}