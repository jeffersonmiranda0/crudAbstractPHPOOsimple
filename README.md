# crudAbstractPHPOOsimple

Este modelo abstrato foi desenvolvido com intuito de facilitar a criação de CRUDs utilizando sua classe.
Atualmente encontrá-se em processo de desenvolvimento onde estou trabalhando para aperfeiçoar ainda mais minhas técnicas de desenvolvimento e legibilidade.


## Como usar
Este projeto foi desenvolvido utilizando o modelo MVC. 
Para começar a fazer seus Cruds basta extender o modelo abstrato `Abstract Model`

```
/**
* @Schema (Auth)
* @Table (Carro)
* @NamePk (codigo)
* @Ignore (abc)
* @GenerateTable (true)
*/
class  Carro  extends  AbstractModel
protected $table 	= 'Carro';
protected $schema 	= 'Auth';
protected $namePk 	= 'codigo';
protected $ignore 	= Array();
```
Agora você deve ter notado que foi feito uma anotação na classe informando o `schema`, `tabela`, `pk` e outras configurações. 
Isto foi feito pois será utilizado para configuração de seu **CRUD**.

**[CLIQUE AQUI](https://github.com/jeffersonmiranda0/crudAbstractPHPOOsimple/blob/master/api/Model/Carro.class.php)** para ver todo o exemplo da classe

---
O modelo ainda está passando por atualizações onde os atributos table, schema, namePk e Ignore não serão mais utilizados, passando a ser utilizado apenas o comentário do documento.

## EXEMPLO DE CRUD
```
$carro = new Carro();
//METODO SAVE -> SE ESTE VALOR ESTIVER SETADO ENTÃO REALIZA 
//UPDATE, CASO NAO ESTEJA REALIZA INSERT
$carro->setCodigo("1");
$carro->setAno('2018');
$carro->setMarca('VECTRA123 555d');
$carro->setModelo("Expression insert");
$carro->setNome('Besouro Negro');
$retorno = $carro->save(true);
```
---
# EM BREVE NOVAS ATUALIZAÇÕES E MELHORIAS
Deixe seu comentário ou sugestão
