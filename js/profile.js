
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".partnerAddBtn").addEventListener("click", function() {
        var partnerCode = document.getElementById("partnerCodeInput").value.trim();
        if (partnerCode.length != 10 || isNaN(partnerCode)) {
            alert("Please enter a valid 10-digit code.");
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../profile.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                } else {
                    alert("Error adding partner.");
                }
            }
        };
        xhr.send("partnerCode=" + partnerCode);
    });
});

