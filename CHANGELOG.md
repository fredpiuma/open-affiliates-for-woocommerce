# Changelog

Formato baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.1.0/). O projeto segue [Versionamento Semântico](https://semver.org/lang/pt-BR/).

## [1.0.0] - 2026-11-05

Primeira versão do Open Affiliates, um fork de Ultimate Affiliate Pro 9.4.1 (WPIndeed Development).

### Removido
- Sistema de licenciamento: ativação, revogação, verificação periódica, assistente de licença, detecção de adulteração e mensagens de versão de avaliação.
- Atualização remota do plugin pelo portal do fornecedor original.
- Telemetria: envio periódico de dados do site, opt-in no assistente e nas configurações, e os eventos de rastreamento do ActiveCampaign.
- Avisos de venda: banners de pacotes, Pro AddOns, avaliação e download, e anúncios do painel.
- Integração com Mad Mimi.
- Toda a pasta `documentation/` e os links para o portal do fornecedor.
- Google Charts, Google Fonts e demais conexões a CDNs.

### Alterado
- Todos os recursos antes bloqueados (Banners, PayPal, Stripe, Comissões vitalícias, MLM) estão disponíveis.
- Marca, text domain (`openaffiliates`), prefixos (`af_`, `AF_`, `af-`), namespace (`OpenAffiliates\`), tabelas (`{prefix}af_*`), slug do painel (`openaffiliates`) e shortcodes (`af-*`).
- Fontes servidas localmente (Open Sans, Roboto, Raleway e Noto Sans, licenças OFL/Apache).
- Árvore MLM reescrita em JavaScript e CSS locais.
- Avisos "envia X para Y" nas telas dos serviços externos opcionais.

### Adicionado
- Tela **About & Support** e rodapé do painel com os dados do autor.
- `LICENSE`, `README.md`, `CREDITS.md`, `THIRD-PARTY.md` e `docs/`.
- `languages/openaffiliates.pot`.
