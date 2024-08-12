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

$(document).ready(function () {
    $('#cpfCliente').mask('000.000.000-00', { reverse: true });
});

function validarCPF() {
    var cpf = document.getElementById("cpfCliente").value;
    var erroCpf = document.getElementById("erroCpf");
    cpf = cpf.replace(/[^\d]/g, ''); // Remove qualquer caractere que não seja número
    if (cpf.length !== 11) { // Verifica se o CPF possui 11 dígitos
        erroCpf.textContent = "CPF inválido!";
        return false;
    }
    var firstDigit = cpf.charAt(0); // Verifica se todos os dígitos do CPF são iguais (caso contrário, não é um CPF válido)
    if (cpf.split('').every(digit => digit === firstDigit)) {
        erroCpf.textContent = "CPF inválido!";
        return false;
    }
    var soma = 0;
    for (var i = 0; i < 9; i++) { // Calcula o primeiro dígito verificador
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    var firstCheckDigit = 11 - (soma % 11);
    if (firstCheckDigit > 9) {
        firstCheckDigit = 0;
    }
    if (parseInt(cpf.charAt(9)) !== firstCheckDigit) {// Verifica se o primeiro dígito verificador está correto
        erroCpf.textContent = "CPF inválido!";
        return false;
    }
    soma = 0;
    for (var i = 0; i < 10; i++) {// Calcula o segundo dígito verificador
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    var secondCheckDigit = 11 - (soma % 11);
    if (secondCheckDigit > 9) {
        secondCheckDigit = 0;
    }
    if (parseInt(cpf.charAt(10)) !== secondCheckDigit) {// Verifica se o segundo dígito verificador está correto
        erroCpf.textContent = "CPF inválido!";
        return false;
    }
    erroCpf.textContent = "";
    return true;
}

var cpf = document.getElementById("cpfCliente");
cpf.addEventListener("focusout", validarCPF);

$(document).ready(function () {
    $('#cep').mask('00000-000');
});

function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('logradouro').value = ("");
    document.getElementById('bairro').value = ("");
    document.getElementById('cidade').value = ("");
    document.getElementById('uf').value = ("");
}

document.getElementById('cep').addEventListener('focusout', function () {
    var cep = document.getElementById('cep').value;
    var erroCep1 = document.getElementById("erroCep1");

    // Requisição para a API dos Correios
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                // Preenche os campos de endereço com os dados da API
                document.getElementById('logradouro').value = data.logradouro;
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('cidade').value = data.localidade;
                document.getElementById('uf').value = data.uf;
                erroCep1.textContent = ""; // Remove a mensagem de erro e a classe de estilo do campo de entrada
            } else {
                erroCep1.textContent = "Cep inválido!"; // Exibe a mensagem de erro e aplica a classe de estilo ao campo de entrada
                limpa_formulário_cep()
            }
        })
        .catch(error => {
            console.error('Erro ao preencher o endereço:', error);
            limpa_formulário_cep()
        });
});

function validarSenha() {
    var senhaInput = document.getElementById("senhaUsuario").value;
    var confirmarSenhaInput = document.getElementById("confirmaSenha").value;
    var erroSenha1 = document.getElementById("erroSenha1");

    if (senhaInput !== confirmarSenhaInput) {
        erroSenha1.textContent = "As senhas não correspondem.";
        return false;
    } else {
        erroSenha1.textContent = "";
        return true;
    }
}

var confirmarSenhaInput = document.getElementById("confirmaSenha");
confirmarSenhaInput.addEventListener("focusout", validarSenha);

function validaCliente() {
    var log = document.getElementById("logradouro").value;
    if (!validarData()) {
        Swal.fire({
            title: 'Erro ao cadastrar usuario!',
            text: 'Data de nascimento inválida!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    } else if (!validarCPF()) {
        Swal.fire({
            title: 'Erro ao cadastrar usuario!',
            text: 'O CPF é invalido!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    } else if (!validarSenha()) {
        Swal.fire({
            title: 'Erro ao cadastrar usuario!',
            text: 'As senhas são diferentes!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    } else if (log === "") {
        Swal.fire({
            title: 'Erro ao cadastrar usuario!',
            text: 'O CEP é invalido!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    } else {
        return true;
    }
}