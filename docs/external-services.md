# Serviços externos

O Open Affiliates **não faz nenhuma conexão externa sozinho**: não há verificação de licença, atualização remota, telemetria nem anúncios, e todos os ativos (fontes, ícones, gráficos) são locais.

As conexões abaixo existem porque a função é externa por natureza. Todas ficam **desligadas até alguém configurá-las** (chaves, contas ou opção ativada) e a tela de configuração de cada uma exibe o aviso "envia X para Y".

| Serviço | Destino | Quando acontece | O que é enviado |
| --- | --- | --- | --- |
| PayPal | `api.paypal.com` (e sandbox) | Pagamento de comissões por PayPal | Valores, moeda, e-mail do beneficiário |
| Stripe (SDK clássico, v2 e v3) | `api.stripe.com`, `connect.stripe.com`, `files.stripe.com` | Pagamento por Stripe e cadastro de contas conectadas | Valores, IDs das contas conectadas e dados do cadastro |
| Google reCAPTCHA | `www.google.com/recaptcha` | Cadastro, só se as chaves forem preenchidas | Token do desafio e IP do visitante |
| Mailchimp, AWeber, Campaign Monitor, Constant Contact, iContact, GetResponse, DirectMail, ActiveCampaign | API de cada serviço | Cadastro de afiliado, só com o serviço configurado | Nome, e-mail e IP |
| Pushover | `api.pushover.net` | Notificação por push, só se configurada | Texto da notificação |
| Migração | o próprio site (loopback) | Ao executar a migração de dados | Nada sai do servidor |

O DirectMail (`dm-mailinglist.com`) é chamado por **HTTP sem criptografia**, então nome e e-mail trafegam em texto puro. Prefira outro serviço ou desative essa integração.

O AWeber depende de um aplicativo registrado pelo desenvolvedor original (a autorização usa o ID desse app). Se a integração não autorizar, é preciso registrar um app próprio no AWeber ou não usar o serviço.

## Links nos textos

Alguns textos do painel têm links para documentação de terceiros (Stripe, PayPal, etc.). São links que o usuário clica, não requisições automáticas.

## Como verificar

Em um ambiente de teste, ative `WP_HTTP_BLOCK_EXTERNAL` e registre as chamadas com o filtro `pre_http_request`. O plugin também usa `curl` direto em algumas bibliotecas (PayPal, Stripe, e-mail marketing), então vale conferir com `tcpdump` ou um proxy.
