let table = document.getElementById("tableau");

function myFunction() {
    let input = document.getElementById("myInput");
    let td, i, txtValue;
    let filtre = input.value.toUpperCase();
    let tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().includes(filtre) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
