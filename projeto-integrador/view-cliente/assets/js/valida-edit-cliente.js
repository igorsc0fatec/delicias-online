function validarData() {
    var dataInput = document.getElementById("nascCliente").value;
    var erroData = document.getElementById("erroData");
    var data = new Date(dataInput);
    var hoje = new Date();

    var idade = hoje.getFullYear() - data.getFullYear();
    var mes = hoje.getMonth() - data.getMonth();

    if (mes < 0 || (mes === 0 && hoje.getDate() < data.getDate())) {
        idade--;
    }

    if (idade < 18) {
        erroData.textContent = "Idade menor que 18 anos!";
        return false;
    } else if (idade > 100) {
        erroData.textContent = "Idade maior que 100 anos!";
        return false;
    } else {
        erroData.textContent = "";
        return true;
    }
}

var data = document.getElementById("nascCliente");
data.addEventListener("focusout", validarData);

function validaEditCliente() {
    if (!validarData()) {
        Swal.fire({
            title: 'Essa data é invalida!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    } else {
        return true;
    }
}