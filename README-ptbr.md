solo
====

> <em>coleção de classe para o desenvolvimento individual</em>
- - -

>Leia esta página em [Ingles](http....README.md)
- - -
### Informações do Autor:
><strong>nome:</strong> Wallace Rio<br>
><strong>email:</strong> wallrio@gmail.com<br>
><strong>site:</strong> [wallrio.com](http://wallrio.com/ "WallRio.com")

><strong>página do projeto:</strong> [solo.wallrio.com](http://solo.wallrio.com/ "solo.wallrio.com")

<br>
### Instalação:

>Este pacote esta disponivel via [Composer](https://packagist.org/packages/wallrio/solo).

### Utilizando:	

<pre><code>
$translation = new \WallRio\Solo\Translation();     
echo $translation->go('Text to translate');
</code></pre>

### Funções disponiveis:




+ <strong>go</strong>( Source = STRING , goSimilar = INTEGER , showSimilar = BOOLEAN , langaguePrefixFrom = STRING, langaguePrefixTo = STRING)

>><i>descrição:</i> Este método traduz o texto passado pelo parametro.

>><i>returno:</i> (string)

>><i>exemplo:</i>
	<pre><code>
		$translation = new \WallRio\Solo\Translation();     
		echo $translation->go('Text to translate');		
	</code></pre>

>><i>exemplo de saida:</i> 'Texto para traduzir'





+ <strong>goSimilar</strong>( Source = STRING )

>><i>descrição:</i> Este método mostra as traduções similares a uma palavra.

>><i>returno:</i> (string)

>><i>exemplo:</i>
	<pre><code>
		$translation = new \WallRio\Solo\Translation();     
		echo $translation->goSimilar('home');
	</code></pre>

>><i>exemplo de saida:</i> 'casa,inicio,moradia'





+ <strong>stylefont</strong>( STYLE = STRING )

>><i>descrição:</i> Este método é utilizada para formatar de forma global como o texto traduzido.

>><i>returno:</i> (void) este método não tem retorno

>><i>exemplo:</i>
	<pre><code>
		$translation = new \WallRio\Solo\Translation();  
		$translation->stylefont('ucfirst:true;ucwords:false');
	</code></pre>






+ <strong>listLanguages</strong>()

>><i>descrição:</i> Este método é utilizado para listar os idiomas disponiveis.

>><i>returno:</i> (array)

>><i>exemplo:</i>
	<pre><code>
		$translation = new \WallRio\Solo\Translation();  
		$translation->listLanguages();
		var_dump($translation);
	</code></pre>





+ <strong>setLanguageTo</strong>( langaguePrefix = STRING )

>><i>descrição:</i> Este método é utilizado para escolher o idioma destino da tradução.

>><i>returno:</i> (void)

>><i>exemplo:</i>
	<pre><code>
		$translation = new \WallRio\Solo\Translation();  
		$translation->setLanguageTo('ptbr');		
	</code></pre>







+ <strong>setLanguageFrom</strong>( langaguePrefix = STRING )

>><i>descrição:</i> Este método é utilizado para escolher o idioma origem da tradução.

>><i>returno:</i> (void)

>><i>exemplo:</i>
	<pre><code>
		$translation = new \WallRio\Solo\Translation();  
		$translation->setLanguageFrom('ptbr');		
	</code></pre>







+ <strong>getLanguageNameTo</strong>()

>><i>descrição:</i> Este método é utilizado para capturar o nome da linguagem de destino da tradução.

>><i>return:</i> (string)

>><i>exemplo:</i>
	<pre><code>
		$translation = new \WallRio\Solo\Translation();  
		echo $translation->getLanguageNameTo();		
	</code></pre>
