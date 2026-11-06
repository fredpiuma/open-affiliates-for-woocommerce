# Instalação e primeiros passos

## Instalação

1. Copie `open-affiliates-for-woocommerce/` para `wp-content/plugins/`.
2. Ative **Open Affiliates** em *Plugins*.
3. Abra **Open Affiliates** no menu do painel. O assistente inicial cria as páginas básicas (cadastro, login, portal do afiliado).

## Páginas e shortcodes

As páginas do assistente usam estes shortcodes, que também podem ser colocados em qualquer página:

`[af-register]`, `[af-login-form]`, `[af-logout]`, `[af-reset-password]`, `[af-account-page]`, `[af-user-become-affiliate]`, `[af-listing-affiliates]`, `[af-public-affiliate-info]`, `[af-product-links]`, `[af-landing-commission]`, `[af-affiliate]`, `[af-if-affiliate]`, `[af-if-not-affiliate]`, `[af-visitor-referred]`, `[af-visitor-not-referred]`.

## Link de afiliado

O link de indicação usa o parâmetro `ref`, por exemplo `https://sualoja.com/?ref=1`, onde `1` é o ID do afiliado. O plugin grava um cookie `af_referral` no visitante. Quando um pedido é concluído no WooCommerce, a comissão é registrada para esse afiliado.

## Idioma

A interface acompanha o idioma do site. Para usar o português do Brasil, vá em **Configurações > Geral > Idioma do site** e escolha *Português do Brasil*. O conteúdo padrão (e-mails, mensagens de login e cadastro, páginas e banners de demonstração) é criado no idioma vigente no momento da criação. Em um site que já tinha esse conteúdo em inglês, ele continua em inglês até você restaurar o padrão ou editá-lo manualmente.

## Sobre e suporte

O menu **Open Affiliates > About & Support** reúne os contatos do mantenedor.
