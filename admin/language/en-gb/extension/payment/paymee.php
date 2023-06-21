<?php
// Heading
$_['heading_title']              = 'PayMee';

// Text
$_['text_extension']             = 'Extensões';
$_['text_success']               = 'Pagamento por PayMee modificado com sucesso!';
$_['text_edit']                  = 'Configurações do pagamento por PayMee';
$_['text_paymee']                = '<a target="_blank" href="https://www.paymee.com.br/vender/"><img src="view/image/payment/paymee.jpg" alt="PayMee" title="PayMee" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_info_geral']            = 'Abaixo, você deve preencher as configurações básicas da extensão.';
$_['text_info_api']              = 'Abaixo, você deve preencher as configurações para integração com a PayMee.';
$_['text_info_situacoes']        = 'Abaixo, você deve selecionar as situações de pedido que serão atribuídas automaticamente pela extensão conforme o retorno da PayMee.';
$_['text_info_campos']           = 'Abaixo, você deve selecionar onde a extensão encontrará os dados do cliente para enviar ao PayMee.<br>
                                    <strong>Importante:</strong> Caso ainda não tenha criado os campos personalizados, vá no menu <strong>Clientes > Personalizar cadastro</strong>.<br>
                                    <strong>Observação:</strong> Caso sua loja não utilize os campos personalizados, selecione a opção "Coluna na tabela de pedidos", e selecione a coluna (na tabela *_order).';
$_['text_info_finalizacao']      = 'As informações abaixo serão utilizadas no checkout da loja.';
$_['text_url_notificacao']       = 'URL de notificação:';
$_['text_pix']                   = 'PIX';
$_['text_bb_transfer']           = 'Transferência Banco do Brasil';
$_['text_bradesco_transfer']     = 'Transferência Banco Bradesco';
$_['text_itau_transfer_generic'] = 'Transferência Banco Itaú';
$_['text_cef_transfer']          = 'Transferência Caixa Econômica Federal';
$_['text_original_transfer']     = 'Transferência Banco Original';
$_['text_santander_transfer']    = 'Transferência Banco Santander';
$_['text_inter_transfer']        = 'Transferência Banco Inter';
$_['text_bs2_transfer']          = 'Transferência Banco BS2';
$_['text_itau_di']               = 'Depósito Banco Itaú';
$_['text_santander_di']          = 'Depósito Banco Santander';
$_['text_24_horas']              = '24 horas';
$_['text_48_horas']              = '48 horas';
$_['text_72_horas']              = '72 horas';
$_['text_campo']                 = 'Campo:';
$_['text_coluna']                = 'Coluna na tabela de pedidos';
$_['text_razao']                 = 'Coluna Razão Social do cliente:';
$_['text_cnpj']                  = 'Coluna CNPJ do cliente:';
$_['text_cpf']                   = 'Coluna CPF do cliente:';
$_['text_botao']                 = 'Cor do botão FINALIZAR E RECEBER INSTRUÇÕES na finalização do pedido';
$_['text_texto']                 = 'Cor do texto';
$_['text_fundo']                 = 'Cor do fundo';
$_['text_borda']                 = 'Cor da borda';

// Tab
$_['tab_geral']                  = 'Configurações';
$_['tab_api']                    = 'API';
$_['tab_situacoes']              = 'Situações';
$_['tab_campos']                 = 'Dados do cliente';
$_['tab_finalizacao']            = 'Finalização';

// Button
$_['button_save_stay']           = 'Salvar e continuar';
$_['button_save']                = 'Salvar e sair';

// Entry
$_['entry_lojas']                = 'Lojas:';
$_['entry_tipos_clientes']       = 'Tipos de clientes:';
$_['entry_total']                = 'Total mínimo:';
$_['entry_geo_zone']             = 'Região geográfica:';
$_['entry_status']               = 'Situação:';
$_['entry_sort_order']           = 'Posição:';
$_['entry_url']                  = 'Endereço de callback:';
$_['entry_x_api_key']            = 'x-api-key:';
$_['entry_x_api_token']          = 'x-api-token:';
$_['entry_sandbox']              = 'Sandbox:';
$_['entry_vencimento']           = 'Vencimento:';
$_['entry_metodos']              = 'Métodos:';
$_['entry_debug']                = 'Debug:';
$_['entry_produto_digital']      = 'Venda de produto digital?';
$_['entry_situacao_pendente']    = 'Pendente:';
$_['entry_situacao_analise']     = 'Em análise:';
$_['entry_situacao_pago']        = 'Pago:';
$_['entry_custom_razao_id']      = 'Razão Social:';
$_['entry_custom_cnpj_id']       = 'CNPJ:';
$_['entry_custom_cpf_id']        = 'CPF:';
$_['entry_titulo']               = 'Título da extensão:';
$_['entry_imagem']               = 'Imagem da extensão:';
$_['entry_one_checkout']         = 'Modo One Checkout:';
$_['entry_botao_normal']         = 'Cor inicial:';
$_['entry_botao_efeito']         = 'Cor com efeito:';

// Help
$_['help_lojas']                 = 'Lojas em que a extensão será oferecida como forma de pagamento.';
$_['help_tipos_clientes']        = 'Tipos de clientes para quem a forma de pagamento será oferecida.';
$_['help_total']                 = 'É o valor mínimo que o pedido deve alcançar para que a extesão seja habilitada. Deixe em branco se não houver valor mínimo.';
$_['help_url']                   = 'Adicionada em sua conta na PayMee, através do menu API & WebHooks, onde você deve marcar a opção URL - Pagamento.';
$_['help_x_api_key']             = 'Está em sua conta na PayMee, através do menu API & WebHooks.';
$_['help_x_api_token']           = 'Está em sua conta na PayMee, através do menu API & WebHooks.';
$_['help_sandbox']               = 'Selecione Sim, para utilizar a extensão no ambiente sandbox.';
$_['help_vencimento']            = 'Selecione o tempo para a solicitação de pagamento expirar.';
$_['help_metodos']               = 'Selecione os métodos de pagamento da PayMee que você deseja habiltar na loja.';
$_['help_debug']                 = 'Selecione Sim, caso deseje visualizar as informações enviadas pela API da Cielo para a loja. Por padrão deixe Não.';
$_['help_produto_digital']       = 'Selecione Sim, caso você venda produtos digitais que são liberados automaticamente após a confirmação do pagamento.';
$_['help_situacao_pendente']     = 'Aguardando o pagamento.';
$_['help_situacao_analise']      = 'Pago com valor diferente.';
$_['help_situacao_pago']         = 'Pago com valor igual.';
$_['help_custom_razao_id']       = 'O campo Razão Social não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Conta, e selecione-o para que a extensão funcione corretamente.';
$_['help_custom_cnpj_id']        = 'O campo CNPJ não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Conta, e selecione-o para que a extensão funcione corretamente.';
$_['help_custom_cpf_id']         = 'O campo CPF não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Conta, e selecione-o para que a extensão funcione corretamente.';
$_['help_titulo']                = 'Título da forma de pagamento PayMee que será exibido para o cliente na etapa de seleção da forma de pagamento.';
$_['help_imagem']                = 'Caso não deseje exibir um título, você pode selecionar uma imagem que será exibida para o cliente na etapa de seleção da forma de pagamento.';
$_['help_one_checkout']          = 'Selecione Sim, caso esteja utilizando um checkout em que seja necessário salvar os dados do cliente antes de finalizar o pedido.';
$_['help_botao_normal']          = 'Cor do botão quando o mesmo não estiver pressionado ou não estiver com o mouse sobre ele.';
$_['help_botao_efeito']          = 'Cor do botão quando o mesmo for pressionado ou quando o mouse estiver sobre ele.';

// Error
$_['error_permission']           = 'Atenção: Você não tem permissão para modificar a extensão PayMee!';
$_['error_warning']              = 'Atenção: A extensão não foi configurada corretamente! Verifique todos os campos para corrigir os erros.';
$_['error_stores']               = 'É necessário selecionar pelo menos uma loja.';
$_['error_customer_groups']      = 'É necessário selecionar pelo menos um tipo de cliente.';
$_['error_x_api_key']            = 'O campo x-api-key é obrigatório.';
$_['error_x_api_token']          = 'O campo x-api-token é obrigatório.';
$_['error_metodos']              = 'É necessário selecionar pelo menos um método de pagamento.';
$_['error_campos_coluna']        = 'Selecione o nome da coluna.';
$_['error_titulo']               = 'O campo Título da extensão é obrigatório.';
