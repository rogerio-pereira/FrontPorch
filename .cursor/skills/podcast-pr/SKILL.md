---
title: "Podcast humorístico sobre Pull Requests"
description: "Lê todas as PRs de um repositório em inglês, gera um roteiro de podcast em português do Brasil com humor técnico e cria um arquivo de áudio local para escuta."
language: "pt-BR"
tags:
  - github
  - pull-requests
  - podcast
  - tts
  - audio
  - code-review
output:
  script: true
  audio: true
  default_audio_file: "cursor/skills/podcast-pr/audios/yyyy-mm-dd.mp3"
---

# Skill: Podcast humorístico sobre Pull Requests

## Objetivo

Ler todas as Pull Requests de um repositório Git, analisar o conteúdo técnico e gerar um podcast em português do Brasil, com tom bem-humorado, descontraído e estilo “mesa redonda de devs”.

O repositório pode estar em inglês, mas todo o roteiro e o áudio final devem ser produzidos em português do Brasil.

Ao final, a skill deve gerar:

1. Um roteiro completo do podcast.
2. Um arquivo de áudio narrado.
3. O arquivo salvo localmente para que o usuário possa ouvir.

Arquivos de saída (usar a data do dia da geração, formato `yyyy-mm-dd`):

```text
.cursor/skills/podcast-pr/audios/yyyy-mm-dd.md    # roteiro
.cursor/skills/podcast-pr/audios/yyyy-mm-dd.mp3   # áudio final
```

---

## Entrada esperada

A skill deve receber, quando disponível:

- URL ou caminho local do repositório.
- Intervalo de PRs, se houver.
- Branch base, se necessário.
- Token ou credenciais de acesso, caso o repositório seja privado.
- Preferência de duração do podcast, se informada.
- Preferência de estilo de vozes, se informada.

Se nada for especificado sobre o intervalo, analisar todas as PRs acessíveis no repositório.

---

## Coleta de informações

Para cada Pull Request, coletar e analisar:

- Número da PR.
- Título.
- Autor.
- Descrição.
- Status.
- Data de criação e merge/fechamento, quando disponível.
- Branch de origem e destino.
- Commits.
- Arquivos alterados.
- Diferenças principais no código.
- Comentários.
- Reviews.
- Discussões relevantes.
- Labels.
- Indícios de risco, complexidade ou mudança sensível.

Também identificar padrões gerais no conjunto de PRs, como:

- Muitas correções pequenas.
- Refactors grandes.
- Mudanças recorrentes em CSS/layout.
- Cron jobs ou filas alteradas.
- Testes adicionados ou removidos.
- PRs com pouca descrição.
- Commits suspeitos como `quick fix`, `temporary`, `hotfix`, `works now`, `fix again`.
- Arquivos muito alterados.
- Mudanças com risco de regressão.

---

## Regras de conteúdo

- Nunca inventar mudanças que não existam nas PRs.
- Não atribuir intenção negativa aos autores.
- Não fazer humor ofensivo, pessoal ou humilhante.
- O humor deve focar em situações técnicas, código legado, bugs, CSS, gambiarras, nomes estranhos, regex, cron jobs, filas e decisões curiosas.
- Preservar nomes técnicos originais quando fizer sentido.
- Traduzir explicações naturalmente para português do Brasil.
- Não apenas listar PRs; transformar a análise em entretenimento técnico.
- O podcast deve parecer uma **conversa real** entre dois humanos — não um texto lido em monótono.
- Incluir pausas naturais, interjeições, réplicas curtas e reações (“sério?”, “exato”, “nossa”, “olha só”).
- Alternar falas curtas entre hosts; evitar blocos longos de um só lado.
- O texto deve funcionar bem quando sintetizado em voz (frases orais, ritmo de mesa redonda).

## Regras de programação

- Rodar **tudo dockerizado** (coleta pode usar MCP/`gh`; TTS via `scripts/run-docker.sh`).
- Áudio **sempre** em `.cursor/skills/podcast-pr/audios/yyyy-mm-dd.mp3` (mesma data do roteiro `.md`).
- Gerar áudio com `scripts/generate_audio.py` (edge-tts, duas vozes neurais distintas, prosódia variável).

---

## Estilo do podcast

Tom geral:

- Bem-humorado.
- Técnico, mas acessível.
- Conversa natural entre devs.
- Levemente irônico.
- Sem agressividade.
- Com piadas recorrentes quando fizer sentido.

Inspirações de estilo:

- Podcast de tecnologia descontraído.
- Mesa redonda de desenvolvedores.
- Review de sprint com energia de sexta-feira à tarde.

Temas de humor permitidos:

- CSS quebrado.
- Layout com pixels demais.
- Regex assustadoras.
- Cron jobs suspeitos.
- Filas que parecem ter vontade própria.
- Legacy code.
- Hotfixes.
- Workarounds.
- TODOs esquecidos.
- Variáveis com nomes ruins.
- Commits misteriosos.
- “Funciona na minha máquina”.
- “Temporary fix” que virou patrimônio histórico.

---

## Estrutura do roteiro

Gerar o roteiro no formato abaixo.

### 1. Abertura

Incluir:

- Nome fictício do episódio.
- Introdução engraçada.
- Apresentação dos hosts.
- Explicação breve do que será analisado.
- Resumo geral da “energia” das PRs.

Exemplo de estilo:

```text
HOST 1: Bem-vindos ao Code & Caos, o podcast onde cada Pull Request é uma promessa... e às vezes uma ameaça.

HOST 2: Hoje vamos mergulhar nas PRs desse repositório e descobrir quem trouxe melhoria, quem trouxe bug, e quem claramente fez commit depois do terceiro café.
```

---

### 2. Blocos por Pull Request

Para cada PR, criar um bloco com:

- Número da PR.
- Título.
- Autor.
- Resumo técnico.
- Impacto no sistema.
- Arquivos ou áreas mais afetadas.
- Comentários/reviews relevantes.
- Possíveis riscos.
- Pontos positivos.
- Comentário humorado dos hosts.
- Nota de caos de 0 a 10.
- Probabilidade de bug em produção.

Formato sugerido:

```text
HOST 1: Agora vamos para a PR #123: "Fix user notification queue".

HOST 2: Pelo título, parece simples. E como todo dev experiente sabe, quando parece simples, é porque o perigo ainda não carregou no browser.

HOST 1: Tecnicamente, essa PR altera o processamento de notificações na fila, ajusta o retry e mexe na forma como os erros são registrados.

HOST 2: Impacto real: menor chance de mensagem perdida, mas também aquela possibilidade gostosa de descobrir em produção que a fila virou um karaokê de exceções.

HOST 1: Nota de caos: 6 de 10.

HOST 2: Probabilidade de bug em produção: média. Não é incêndio, mas eu deixaria o CloudWatch aberto.
```

---

### 3. Segmentos especiais

Depois de passar pelas PRs, criar segmentos especiais com base na análise real.

Incluir quando aplicável:

- “PR mais caótica”.
- “Isso aqui foi feito sexta 18h”.
- “Regex que deveria ser crime”.
- “Commit que merece terapia”.
- “Refactor que derrubaria staging”.
- “TODO mais ameaçador”.
- “Melhor melhoria real da semana”.
- “Mudança pequena com cara de bomba relógio”.
- “PR mais subestimada”.

Não criar uma categoria se nenhuma PR se encaixar nela.

---

### 4. Encerramento

Incluir:

- Resumo geral.
- Ranking das PRs mais perigosas.
- Melhor melhoria da semana.
- Principal risco técnico observado.
- Frase final engraçada.

Exemplo:

```text
HOST 1: E esse foi o episódio de hoje. Tivemos refactor, bugfix, CSS querendo abrir um portal, e uma fila que claramente precisa de férias.

HOST 2: Lembrem-se: antes de dar merge, rodem os testes. E se não tiver teste, pelo menos façam uma oração para o staging.
```

---

## Roteiro conversacional (obrigatório antes do TTS)

O roteiro deve soar como **dois devs na mesa**, não como narração de documentário:

| Host | Persona sugerida | Estilo de fala |
|------|------------------|----------------|
| HOST 1 | Mais direto, puxa os tópicos | Frases médias, energia um pouco maior, puxa piadas |
| HOST 2 | Reage, complementa, ironiza | Réplicas curtas, perguntas de volta, “né?”, “faz sentido” |

Regras de escrita:

- **Alternar** HOST 1 e HOST 2 a cada 1–3 frases; raramente mais de 4 linhas seguidas do mesmo host.
- Misturar **pergunta → resposta** em vez de só exposição técnica.
- Usar **frases curtas** (ideal &lt; 120 caracteres por linha `HOST n:`).
- Incluir **reações** antes do detalhe técnico (“Ah, essa é boa”, “Aqui o negócio complica”).
- Evitar tom de “lista de PR”: transformar em comentário de mesa redonda.
- Remover markdown do texto falado; manter nomes técnicos pronunciáveis.
- Marcações de pausa no roteiro (o gerador converte em silêncio real):

```text
[pausa curta]   # troca rápida de falante
[pausa média]   # mudança de assunto / PR
[pausa longa]   # segmento especial ou encerramento de bloco
[risada leve]   # após piada (silêncio breve, sem efeito sonoro)
```

---

## Geração do áudio

Após o roteiro final em `audios/yyyy-mm-dd.md`:

1. Executar (na raiz da skill):

```bash
.cursor/skills/podcast-pr/scripts/run-docker.sh yyyy-mm-dd
```

2. O pipeline usa **edge-tts** (neural, pt-BR) com:
   - **HOST 1:** `pt-BR-AntonioNeural` — ritmo um pouco mais rápido, pitch levemente variável.
   - **HOST 2:** `pt-BR-FranciscaNeural` — timbre distinto, ritmo mais conversacional.
   - **Prosódia por linha:** `rate`, `pitch` e `volume` variam a cada fala (evita voz “engessada” e igual).
   - **Pausas dinâmicas:** mais curtas entre troca de host; um pouco maiores após pergunta ou `?`.

3. Saída única em:

```text
.cursor/skills/podcast-pr/audios/yyyy-mm-dd.mp3
```

Criar `audios/` se não existir. Não usar nome fixo `podcast_prs.mp3`.

Dependências: `scripts/requirements.txt` (`edge-tts>=7.2.0`, `pydub`); imagem `python:3.12-slim` + `ffmpeg` no container.

---

## Saída esperada

A resposta final deve incluir:

- Confirmação de que as PRs foram analisadas.
- Link ou caminho do roteiro gerado, se salvo em arquivo.
- Caminho local do áudio final.
- Observações importantes, se alguma PR não pôde ser lida.
- Aviso claro caso comentários, reviews ou arquivos alterados não estejam acessíveis.

Formato final sugerido:

```text
Podcast gerado com sucesso.

Roteiro:
cursor/skills/podcast-pr/audios/yyyy-mm-dd.md

Áudio:
.cursor/skills/podcast-pr/audios/yyyy-mm-dd.mp3

Observações:
- Foram analisadas 42 PRs.
- 3 PRs não tinham descrição.
- Reviews estavam indisponíveis para 2 PRs por limitação de permissão.
```

---

## Critérios de qualidade

Antes de finalizar, verificar:

- O roteiro está todo em português do Brasil.
- As informações técnicas vieram das PRs reais.
- Não há invenções sobre mudanças ou intenções dos autores.
- O humor é leve e seguro.
- O áudio foi realmente gerado.
- O arquivo de áudio existe no caminho local esperado.
- O roteiro soa como **diálogo** (alternância, reações, frases curtas).
- O áudio usa **duas vozes claramente distintas** e ritmo de conversa (não monótono/lento/igual).
- O MP3 existe em `audios/yyyy-mm-dd.mp3` com a mesma data do roteiro.
- As PRs mais importantes receberam mais atenção do que PRs triviais.
- O resultado final é divertido, mas ainda tecnicamente útil.
