let checkall = document.getElementById("check-all");
let checkboxes = document.querySelectorAll("input[type=checkbox]");

checkall.addEventListener("click", function (event) {
    let isChecked = checkall.checked;
    for (element of checkboxes) {
        element.checked = !!isChecked;
    }
})

checkall.checked = true;
for (element of checkboxes) {
    element.checked = true;
}
