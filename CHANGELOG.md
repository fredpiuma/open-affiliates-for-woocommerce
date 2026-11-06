# Changelog

Formato baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.1.0/). O projeto segue [Versionamento Semântico](https://semver.org/lang/pt-BR/).

## [Não lançado]

### Adicionado
- Zona de perigo em **Configurações > Admin Workflow** com dois botões, ambos liberados só depois de digitar `RESET`:
  - **Restaurar configurações padrão**: apaga as opções do plugin e os padrões voltam sozinhos; afiliados, indicações, pagamentos, cliques, banners, níveis e notificações são mantidos, assim como as páginas atribuídas.
  - **Reset de fábrica**: apaga as tabelas, opções e metadados do plugin, limpa os agendamentos, envia as páginas padrão para a lixeira e reabre o assistente de configuração (a reinstalação ocorre no próximo carregamento do painel). Usuários do WordPress e pedidos do WooCommerce não são alterados.
- Ação AJAX `af_ajax_factory_reset`, que exige administrador (`manage_options`), token CSRF do painel e a palavra `RESET` no servidor.
- Métodos `AfDb::get_plugin_table_names()`, `AfDb::reset_settings()` e `AfDb::factory_reset()`; `AfDb::unistall()` passa a usar a mesma lista de tabelas.

### Observação
- O reset de fábrica age somente no site atual (`$wpdb->prefix`) e nunca em outros sites de uma rede multisite. Porém os metadados de apelido (slug) de afiliados ficam na tabela `usermeta`, compartilhada pela rede, e também são removidos.
- As páginas padrão vão para a lixeira (reversível), não são apagadas definitivamente.

## [1.1.0] - 2026-11-06

### Adicionado
- Tradução completa para português do Brasil (`languages/openaffiliates-pt_BR.po` e `.mo`), com cerca de 2.600 textos.
- Os e-mails padrão (18 modelos), as opções padrão (mensagens de login e cadastro, textos de ajuda, assuntos e corpos de notificações), as páginas padrão, os banners de demonstração e os níveis de demonstração agora são traduzíveis e seguem o idioma do site no momento em que são criados.
- Funções auxiliares `af_server_host()`, `af_server_request_uri()` e `af_current_url()`.

### Alterado
- O idioma do plugin passa a ser carregado em `plugins_loaded` (antes, em `init`), para que o conteúdo padrão já nasça traduzido e sem o aviso de carregamento antecipado do text domain.
- Alertas do painel (JavaScript) passam a vir do arquivo de tradução.
- `languages/openaffiliates.pot` regenerado com os novos textos.

### Corrigido
- Avisos `Undefined array key "HTTP_HOST"` ao executar o plugin por WP-CLI (por exemplo, em `wp plugin install --force`): o plugin deixa de acessar `$_SERVER['HTTP_HOST']` e `$_SERVER['REQUEST_URI']` diretamente.

### Observação
- Instalações existentes mantêm os textos padrão em inglês já gravados no banco de dados. A tradução vale para o que for criado depois: instalações novas, o botão de restaurar o padrão dos e-mails e páginas ou banners novos.

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
