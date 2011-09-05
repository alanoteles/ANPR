<?php
    class HTML_reviews {

        function showReviews($rows, $option) {
        ?>
        
       
        <table>
            <?php
                foreach($rows as $row) {
                    $link = 'index.php?option=' . $option . '&id=' . $row->id . '&task=view';
                    echo '<tr>
                    <td> <a href="' . $link . '">' . $row->name . '</a>
                    </td> </tr>';
                }
            ?>
        </table>
        <?php
        }

        function showReview($row, $option) { ?>
            
            <style type="text/css">
    .formLayout
    {
        background-color: #f3f3f3;
        border: solid 1px #a1a1a1;
        padding: 10px;
        width: 300px;
    }
    
    .formLayout label, .formLayout input
    {
        display: block;
        width: 120px;
        float: left;
        margin-bottom: 10px;
    }
 
    .formLayout label
    {
        text-align: right;
        padding-right: 20px;
    }
 
    br
    {
        clear: left;
    }
    </style>
            <form action="index.php?option=com_ckforms&view=ckforms&task=send&id=1" method="post" name="ckform" id="ckform1" class="ckform ">
    
                
                
                <div class="formLayout">
                    <label>Nome completo :</label>
                    <input id="nome" name="nome"><br>
                    
                    <label>E-mail :</label>
                    <input id="email" name="email"><br>
                    
                    <label>Identifica��o</label>
                    <select id="identificacao">
                        <option value="advogado">Advogado&nbsp;</option>
			<option value="cidadao"  >Cidad�o&nbsp;</option>
			<option value="magistrado"  >Magistrado&nbsp;</option>
			<option value="membro_mp"  >Membro MP&nbsp;</option>
			<option value="associado_anpr"  >Associado ANPR&nbsp;</option>
                    </select><br>
        
                    <label>Telefone :</label>
                    <input id="dddfixo" name="dddfixo"><br>
                    <input id="dddfixo" name="fonefixo"><br>
                    
                    <label>Endere�o</label>
                    <textarea id="endereco" name="endereco" cols="10" rows="5"></textarea><br>
                    
                    <label>Estado</label>
                    <select id="estado">
                        <option value="0" selected="selected" >Selecione um estado&nbsp;</option>
                        <option value="AC"  >Acre&nbsp;</option>
                        <option value="AL"  >Alagoas&nbsp;</option>

                        <option value="AP"  >Amap�&nbsp;</option>
                        <option value="AM"  >Amazonas&nbsp;</option>
                        <option value="BA"  >Bahia&nbsp;</option>
                        <option value="CE"  >Cear�&nbsp;</option>
                        <option value="DF"  >Distrito Federal&nbsp;</option>
                        <option value="ES"  >Esp�rito Santo&nbsp;</option>

                        <option value="GO"  >Goi�s&nbsp;</option>
                        <option value="MA"  >Maranh�o&nbsp;</option>
                        <option value="MT"  >Mato Grosso&nbsp;</option>
                        <option value="MS"  >Mato Grosso do Sul&nbsp;</option>
                        <option value="MG"  >Minhas Gerais&nbsp;</option>
                        <option value="PA"  >Par�&nbsp;</option>

                        <option value="PB"  >Para�ba&nbsp;</option>
                        <option value="PR"  >Paran�&nbsp;</option>
                        <option value="PE"  >Pernambuco&nbsp;</option>
                        <option value="PI"  >Piau�&nbsp;</option>
                        <option value="RJ"  >Rio de Janeiro&nbsp;</option>
                        <option value="RN"  >Rio Grande do Norte&nbsp;</option>

                        <option value="RS"  >Rio Grande do Sul&nbsp;</option>
                        <option value="RO"  >Rond�nia&nbsp;</option>
                        <option value="RR"  >Roraima&nbsp;</option>
                        <option value="SC"  >Santa Catarina&nbsp;</option>
                        <option value="SP"  >S�o Paulo&nbsp;</option>
                        <option value="SE"  >Sergipe&nbsp;</option>

                        <option value="TO"  >Tocantins&nbsp;</option>
                    </select><br>
        
                    <label>Assunto</label>
                    <select id="assunto">
                        <option value="0" selected="selected" >Selecione um assunto&nbsp;</option>
			<option value="critica"  >Critica / Elogio&nbsp;</option>
			<option value="denuncia"  >Den�ncia&nbsp;</option>
			<option value="duvida"  >D�vida&nbsp;</option>
			<option value="reclamacao"  >Reclama��o&nbsp;</option>
			<option value="sugestao"  >Sugest�o&nbsp;</option>
                    </select><br>
        
                    <label>Mensagem</label>
                    <textarea id="mensagem" name="mensagem" cols="10" rows="5"></textarea><br>
		<input name="submit_bt" id="submit_bt" type="submit" value="Enviar"  />

    </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                



    
</form>
    
    <!--- --->
            
            <?php
                $link = 'index.php?option=' . $option ;
            ?>
            
            <a href="<?php echo $link; ?>">&lt; return to the reviews</a>
        
        <?php
        }
    }
?>
    