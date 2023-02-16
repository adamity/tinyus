const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

function copyToClipboard(element) {
    console.log($(element).text());
    var $temp = $("<input>");
    $("body").append($temp);

    $temp.val($(element).text()).select();
    document.execCommand("copy");

    $temp.remove();
    alert("Shorten link copied to clipboard!");
}