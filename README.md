# Open Affiliates

Sistema de afiliados de código aberto para WooCommerce e outras lojas WordPress: rastreamento de indicações, comissões, ranks, MLM, pagamentos e portal do afiliado.

![Licença](https://img.shields.io/badge/licen%C3%A7a-GPL--2.0--or--later-blue)
![Versão](https://img.shields.io/badge/vers%C3%A3o-1.0.0-informational)
![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-21759b)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-777bb4)

## O que é

O Open Affiliates é um fork livre do **Ultimate Affiliate Pro 9.4.1** (WPIndeed Development), distribuído sob GPL-2.0-or-later. Em relação ao original:

- **Todos os recursos liberados.** Não há chave de licença, versão de avaliação nem recurso bloqueado.
- **Sem telemetria.** O plugin não envia dados de uso, do site ou de plugins instalados a ninguém.
- **Sem conexões externas por conta própria.** Nenhuma verificação de licença, atualização remota, anúncio ou chamada de rastreamento. Fontes, ícones e gráficos são servidos localmente (sem Google Fonts nem Google Charts).
- **Marca própria.** Prefixos, tabelas, opções, shortcodes e textos foram renomeados (veja [Compatibilidade](#compatibilidade-com-o-original)).

## Recursos

- Rastreamento de visitas e indicações por link, cupom e cookie.
- Comissões por produto, categoria, rank e comissões vitalícias.
- Ranks de afiliados e árvore de afiliados em vários níveis (MLM).
- Pagamentos: depósito direto, PayPal e Stripe (incluindo Stripe Managed Accounts).
- Portal do afiliado, cadastro, login, listagem pública de afiliados, banners, links de produto e QR Code.
- Notificações por e-mail e integração opcional com serviços de e-mail marketing.
- Importação e exportação de dados.

### Integrações

WooCommerce, Easy Digital Downloads, Ultimate Membership Pro e Ultimate Learning Pro (somente leitura desses plugins), BuddyPress, Elementor, Divi e WPML.

## Requisitos

- WordPress 6.0 ou superior
- PHP 7.4 ou superior
- WooCommerce (ou outra integração de loja compatível) para registrar vendas

## Instalação

1. Copie a pasta `open-affiliates-for-woocommerce` para `wp-content/plugins/`.
2. Ative **Open Affiliates** em *Plugins*.
3. Abra o menu **Open Affiliates** no painel e siga o assistente inicial.

## Shortcodes

| Shortcode | Uso |
| --- | --- |
| `[af-register]` | Formulário de cadastro de afiliado |
| `[af-login-form]` | Formulário de login |
| `[af-logout]` | Link de saída |
| `[af-reset-password]` | Redefinição de senha |
| `[af-account-page]` | Portal do afiliado |
| `[af-user-become-affiliate]` | Botão para um usuário existente virar afiliado |
| `[af-listing-affiliates]` | Listagem pública de afiliados |
| `[af-public-affiliate-info]` | Dados públicos de um afiliado |
| `[af-product-links]` | Links de afiliado para produtos |
| `[af-landing-commission]` | Comissão exibida em página de destino |
| `[af-affiliate]` | Dados do afiliado que indicou o visitante |
| `[af-if-affiliate]` / `[af-if-not-affiliate]` | Conteúdo condicional pelo usuário ser ou não afiliado |
| `[af-visitor-referred]` / `[af-visitor-not-referred]` | Conteúdo condicional pelo visitante ter ou não vindo por indicação |

## Serviços externos

O plugin **não** faz nenhuma conexão externa sozinho. As únicas conexões possíveis são funções que o administrador ou o afiliado configura de propósito, e cada tela de configuração mostra o aviso do que é enviado e para onde. A lista completa está em [`docs/external-services.md`](docs/external-services.md).

## Compatibilidade com o original

O Open Affiliates **não lê** dados do Ultimate Affiliate Pro (tabelas `uap_*`, opções e shortcodes antigos) e não oferece aliases de hooks. Instalações novas começam do zero com o prefixo `af_`. Não há importador de dados do original.

## Contribuindo

Abra uma *issue* ou um *pull request* em <https://github.com/fredpiuma/open-affiliates-for-woocommerce>. Veja também o [CHANGELOG](CHANGELOG.md).

## Baseado em

Este projeto é um fork do **Ultimate Affiliate Pro 9.4.1**, de **WPIndeed Development**, licenciado sob GPL. Os direitos autorais do código original permanecem com seus autores. Detalhes em [CREDITS.md](CREDITS.md). Bibliotecas de terceiros e seus licenciamentos estão em [THIRD-PARTY.md](THIRD-PARTY.md).

## Licença

GPL-2.0-or-later. Veja o arquivo [LICENSE](LICENSE). Como o pacote inclui bibliotecas sob LGPL-3.0, GPL-3.0 e Apache-2.0, o conjunto distribuído deve ser tratado como GPLv3 (detalhes em [THIRD-PARTY.md](THIRD-PARTY.md)).

---

### Precisa de uma solução sob medida para a sua loja?

Desenvolvo plugins, integrações e melhorias para WordPress e WooCommerce, do checkout ao pós-venda. Me conte o que você precisa e vamos encontrar o melhor caminho para o seu projeto.

**Frederico de Castro** · Senior Web Developer & Software Architect

[![Fale comigo no WhatsApp](https://img.shields.io/badge/Fale_comigo_no_WhatsApp-25D366?style=for-the-badge&logo=whatsapp&logoColor=white)](https://wa.me/5511914636944)
[![E-mail](https://img.shields.io/badge/E--mail-D14836?style=for-the-badge&logo=gmail&logoColor=white)](mailto:contato@fredericodecastro.com.br)
[![Site](https://img.shields.io/badge/Site-1F2937?style=for-the-badge&logo=googlechrome&logoColor=white)](https://www.fredericodecastro.com.br/links/)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-0A66C2?style=for-the-badge)](https://www.linkedin.com/in/fredericodecastro/)
[![Telegram](https://img.shields.io/badge/Telegram-2CA5E0?style=for-the-badge&logo=telegram&logoColor=white)](https://t.me/fredericomdecastro)
