# Bibliotecas e ativos de terceiros

O código próprio do Open Affiliates é GPL-2.0-or-later. Este arquivo lista o que foi incorporado de terceiros. Os licenciamentos foram identificados a partir dos cabeçalhos e dos arquivos de licença que acompanham cada biblioteca. Onde não houve identificação segura, a linha está marcada como **verificar**.

## Aviso sobre compatibilidade de licenças

O pacote inclui componentes sob LGPL-3.0 (phpqrcode), GPL-3.0 (Constant Contact) e Apache-2.0 (SDK do PayPal, iContact). Essas licenças não são compatíveis com "somente GPL-2.0", e por isso o conjunto distribuído deve ser tratado como **GPLv3**. O código próprio permanece em "GPL-2.0 ou posterior", o que permite essa combinação.

## JavaScript

| Componente | Versão | Licença | Arquivo |
| --- | --- | --- | --- |
| Bootstrap | 3.3.5 | MIT | `assets/js/bootstrap.js` |
| Chart.js | 2.9.3 | MIT | `assets/js/chart.min.js` |
| Flot | 0.8.2-alpha | MIT | `assets/js/jquery.flot*.js` |
| jQuery Form Plugin | 3.51.0 | MIT / GPL | `assets/js/jquery.form.js` |
| jQuery Mousewheel | 3.1.12 | MIT | `assets/js/jquery.mousewheel.min.js` |
| jQuery MultiSelect | 2.4.22 | verificar | `assets/js/jquery.multiselect.js` |
| jQuery Upload File | 4.0.7 | verificar | `assets/js/jquery.uploadfile.min.js` |
| Croppic | modificado | verificar | `assets/js/croppic.js` |
| IML | 1.0.0 | MIT | `assets/js/iml.min.js` |
| Select2 | 4.0.3 | MIT | `assets/js/select2.min.js` |
| SweetAlert | verificar | MIT (upstream) | `assets/js/sweetalert.js` |
| Moment.js | verificar | MIT | `assets/js/moment.min.js` |
| Tipso | verificar | MIT (upstream) | `assets/js/tipso.min.js` |
| DataTables e extensões Buttons | 1.13.6 / 2.4.1 | MIT | `assets/js/datatables/` |
| Owl Carousel | verificar | MIT (upstream) | `public/listing_users/assets/` |

`sweetalert.js` e `moment.min.js` tinham o cabeçalho de marca do fornecedor original e agora têm o do Open Affiliates. Os arquivos são cópias das bibliotecas públicas e devem voltar a registrar a origem e a versão reais na próxima revisão.

## CSS, fontes e imagens

| Componente | Licença | Local |
| --- | --- | --- |
| Bootstrap 3.3.5 (CSS) | MIT | `assets/css/bootstrap*.css` |
| Font Awesome 4.5.0 | fonte SIL OFL 1.1, CSS MIT | `assets/css/font-awesome*.css`, `assets/fonts/fontawesome-webfont.*` |
| Font Awesome (solid/brands) | verificar | `assets/fonts/fa-*` |
| jQuery UI 1.11.4 | MIT | `assets/css/jquery-ui.min.css` |
| Open Sans, Roboto, Raleway, Noto Sans | OFL 1.1 / Apache-2.0 (via @fontsource) | `assets/fonts/*.woff2`, `assets/fonts/LICENSE-*.txt` |
| Poppins | SIL OFL 1.1 | `assets/fonts/Poppins-*`, `assets/fonts/poppins/` |
| Oswald | SIL OFL 1.1 | `assets/fonts/oswald-*` |
| Bandeiras de países | **verificar** | `assets/flags/*.svg` |

## PHP

| Componente | Licença | Local |
| --- | --- | --- |
| phpqrcode | LGPL-3.0 | `classes/services/qrcode/` |
| SDK PHP do PayPal | Apache-2.0 | `classes/services/paypal/` |
| stripe-php | MIT | `classes/services/stripe/`, `classes/services/stripe-php-master/` (duas cópias, não deduplicadas) |
| Google reCAPTCHA PHP client | BSD-3-Clause (verificar) | `classes/services/recaptcha/` |
| Mailchimp (MCAPI) | MIT | `classes/services/email_services/mailchimp/` |
| Constant Contact | GPL-3.0 | `classes/services/email_services/constantcontact/` |
| iContact | Apache-2.0 | `classes/services/email_services/icontact/` |
| AWeber, Campaign Monitor, DirectMail, ActiveCampaign | verificar | `classes/services/email_services/` |
| Mobile_Detect | MIT (verificar) | `classes/MobileDetect.php` |

## Ativos pendentes de substituição antes da publicação

O pacote original declarava (em `Licensing/README_License.txt`, removido deste repositório) que o código PHP e o HTML integrado são GPL, mas que **CSS, imagens e design** seguiam a licença Envato adquirida pelo comprador. Essa licença não permite redistribuição e não é compatível com a GPL. Enquanto os arquivos abaixo não forem substituídos por material próprio ou de licença livre, o repositório **não deve ser publicado**:

- **Imagens:** `assets/images/` (fotos e banners como `banner_1` a `banner_5`, `login_bg.jpg`, `top_aff_bk_*`, troféus e ícones de painel). Os logotipos SVG do Open Affiliates já são originais.
- **CSS de design próprio do original:** `main_admin.css`, `main_public.css` e `.min`, `templates.css` e `.min`, `wizard.css`.
- **Temas da listagem pública:** os 10 temas em `public/listing_users/themes/`.

Os CSS de terceiros (Bootstrap, jQuery UI, Font Awesome, Select2 etc.) não entram nesta lista, pois têm licença própria.
