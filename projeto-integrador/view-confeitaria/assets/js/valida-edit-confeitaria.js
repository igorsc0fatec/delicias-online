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

function previewImage() {
    const fileInput = document.getElementById('img');
    const preview = document.getElementById('preview');
    const errorSpan = document.getElementById('erroImagem');
    errorSpan.textContent = '';
    const file = fileInput.files[0];

    if (file) {
        if (file.size > 16 * 1024 * 1024) {
            errorSpan.textContent = 'A imagem deve conter no máximo 16MB';
            fileInput.value = '';
            preview.src = 'assets/img/pessoa.webp';
            return false;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
        return true;

    } else {
        errorSpan.textContent = 'O campo da imagem está vazio!';
        preview.src = 'assets/img/pessoa.webp';
        return false;
    }
}

function validaEndereco() {
    var log = document.getElementById("logradouro").value;
    if (log === "") {
        Swal.fire({
            title: 'Erro ao editar dados!',
            text: 'O CEP digitado é invalido!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    } else if (!previewImage()) {
        Swal.fire({
            title: 'Erro ao editar dados!',
            text: 'A Imagem é invalida!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    } else {
        return true;
    }
}