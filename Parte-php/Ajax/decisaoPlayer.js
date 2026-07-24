document.addEventListener("DOMContentLoaded", () => {
    const chat = document.querySelector(".chat-dano");
    const vidaPlayer = document.querySelector("#vida-player");
    const vidaComputador = document.querySelector("#vida-computador");
    const barraPlayer = document.querySelector("#barra-player");
    const barraComputador = document.querySelector("#barra-computador");

    if(!chat) return;

    // 'async' está avisando que essa função pode demorar
    async function execultarAcao(acao) { 
        // 'await' é usado para falar pro código 'Espere até essa operação terminar' - E só funciona numa função assíncorna 'async'
        const resposta = await fetch("Acoes/acaoPlayer.php", { // Espera o PHP terminar
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: `acao=${acao}`
        });

        return await resposta.json(); // Espera trasformar o JSON em objeto JS
    }

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

    // Selecionando a DIV com os BUTTONs
    const arena = document.querySelector(".acoes"); 
    const voltar = document.querySelector(".voltar");

    arena.addEventListener('click', async (e) => { 
        const el = e.target;

        if(el.classList.contains('btn-curar')) {
            const btnCurar = document.querySelector('.btn-curar');

            try {
                btnCurar.disabled = true;

                const dados = await execultarAcao("curar"); 

                if(!dados.ok) {
                    adicionarMensagem(dados.erro || "Erro ao processar a ação.");
                    btnCurar.disabled = false;
                    return;
                }

                dados.mensagens.forEach((msg) => adicionarMensagem(msg));

                if(vidaPlayer) {
                    vidaPlayer.textContent = `HP: ${dados.vidaPlayer} / ${dados.vidaMaxPlayer}`;
                }

                atualizarBarra(barraPlayer, dados.vidaPlayer, dados.vidaMaxPlayer);

                btnCurar.disabled = false;

                return;
            } catch(erro) {
                adicionarMensagem("Falha na comunicação com o servidor.");
                btnCurar.disabled = false;
                console.log(erro);
                return;
            }
        }

        if(el.classList.contains('btn-bater')) {
            const btnCurar = document.querySelector('.btn-curar');
            const btnBater = document.querySelector(".btn-bater");

            try {
                btnBater.disabled = true;

                const dados = await execultarAcao("bater"); // Transforma em uma class as informações enviadas

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

                return;
            } catch(erro) {
                adicionarMensagem("Falha na comunicação com o servidor.");
                btnBater.disabled = false;
                console.log(erro);
                return;
            }
        }

        if(el.classList.contains('btn-reiniciar')) {
            try {
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
        }
    });

    voltar.addEventListener("click", async () => {
        await fetch("Acoes/reinicia.php", {
            method: "POST"
        });

        window.location = "../index.html";
    });
});