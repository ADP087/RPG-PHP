document.addEventListener("DOMContentLoaded", () => {
    const btnCurar = document.querySelector(".btn-curar");
    const btnBater = document.querySelector(".btn-bater");
    const btnReiniciar = document.querySelector(".btn-reiniciar");
    const btnVoltar = document.querySelector(".voltar");

    const chat = document.querySelector(".chat-dano");
    const vidaPlayer = document.querySelector("#vida-player");
    const vidaComputador = document.querySelector("#vida-computador");
    const barraPlayer = document.querySelector("#barra-player");
    const barraComputador = document.querySelector("#barra-computador");

    if(!btnBater || !chat) return;

    function atualizarBarra(barra, atual, max) {
        if(!barra || !max || max <= 0) return;

        const porcentagem = Math.max(0, Math.min(100, (atual / max) * 100));
        barra.style.width = porcentagem + "%";
    }

    function adicionarMensagem(texto) {
        const p = document.createElement("p");
        p.textContent = texto;
        chat.appendChild(p); 
    }

    btnCurar.addEventListener("click", async () => {
        btnCurar.disabled = true;

        try {
            const resposta = await fetch("Acoes/curar.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: "acao=curar"
            });

            const dados = await resposta.json();

            if(!dados.ok) {
                adicionarMensagem(dados.erro || "Erro ao processar a ação.");
                btnCurar.disabled = false;
                return;
            }

            adicionarMensagem(dados.mensagens);

            if(vidaPlayer) {
                vidaPlayer.textContent = `HP: ${dados.vidaPlayer} / ${dados.vidaMaxPlayer}`;
            }

            atualizarBarra(barraPlayer, dados.vidaPlayer, dados.vidaMaxPlayer);

            btnCurar.disabled = false;
        } catch(erro) {
            adicionarMensagem("Falha na comunicação com o servidor.");
            btnCurar.disabled = false;
            console.log(erro);
        }
    });

    btnBater.addEventListener("click", async () => {
        btnBater.disabled = true; // Evita o usuário clicar várias vezes seguidas antes da resposta do servidor chegar

        try {
            const resposta = await fetch("Acoes/bater.php", { // Faz uma requisição para esse arquivo
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: "acao=bater" // Cria uma variável que recebe 'bater'
            });

            const dados = await resposta.json(); // Transforma em uma class as informações enviadas

            if(!dados.ok) {
                adicionarMensagem(dados.erro || "Erro ao processar a ação.");
                btnBater.disabled = false;
                return;
            }

            dados.mensagens.forEach((msg) => adicionarMensagem(msg));

            if(vidaPlayer) {
                vidaPlayer.textContent = `HP: ${dados.vidaPlayer} / ${dados.vidaMaxPlayer}`;
            }

            if(vidaComputador) {
                vidaComputador.textContent = `HP: ${dados.vidaComputador} / ${dados.vidaMaxComputador}`;
            }

            atualizarBarra(barraPlayer, dados.vidaPlayer, dados.vidaMaxPlayer);
            atualizarBarra(barraComputador, dados.vidaComputador, dados.vidaMaxComputador);

            if(dados.fim) {
                btnCurar.disabled = true;
                btnBater.disabled = true;
            } else {
                btnBater.disabled = false;
            }
        } catch(erro) {
            adicionarMensagem("Falha na comunicação com o servidor.");
            btnBater.disabled = false;
            console.log(erro);
        }
    });

    btnReiniciar.addEventListener("click", async () => {
        try{
            const resposta = await fetch("Acoes/reinicia.php", {
                method: "POST"
            });

            const dados = await resposta.json();

            if(dados.ok) {
                location.reload();
            }
        } catch(erro) {
            adicionarMensagem("Erro ao reiniciar batalha");
        }
    });

    btnVoltar.addEventListener("click", async () => {
        await fetch("Acoes/reinicia.php", {
            method: "POST"
        });

        window.location = "../index.html";
    });
});