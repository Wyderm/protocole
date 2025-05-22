let checkall = document.getElementById("check-all");
let checkboxes = document.querySelectorAll("input[type=checkbox]");

checkall.addEventListener("click", function (event) {
    let isChecked = checkall.checked;
    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = !!isChecked;
    }
})

checkall.checked = true;
for (let i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = true;
}
