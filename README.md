solo
====

<em>collection of class for development single</em>



[![Latest Stable Version](https://poser.pugx.org/wallrio/solo/v/stable.svg)](https://packagist.org/packages/wallrio/solo)
[![Total Downloads](https://poser.pugx.org/wallrio/solo/downloads.svg)](https://packagist.org/packages/wallrio/solo)
[![License](https://poser.pugx.org/wallrio/solo/license.svg)](https://packagist.org/packages/wallrio/solo)

Leia esta página em [Português](http....README-ptbr.md)

### Author Information:
<strong>name:</strong> Wallace Rio<br>
<strong>email:</strong> wallrio@gmail.com<br>
<strong>site:</strong> [wallrio.com](http://wallrio.com/ "WallRio.com")

<strong>page project:</strong> [solo.wallrio.com](http://solo.wallrio.com/ "solo.wallrio.com")


### Installation:

Este pacote esta disponivel via [Composer](https://packagist.org/packages/wallrio/solo).

### Using:	

```sh
$translation = new \WallRio\Solo\Translation();     
echo $translation->go('Text to translate');
```

### Functions available:




+ <strong>go</strong>( Source = STRING , goSimilar = INTEGER , showSimilar = BOOLEAN , langaguePrefixFrom = STRING, langaguePrefixTo = STRING)

<i>description:</i> This method represents the last text parameter.

<i>return:</i> (string)

<i>example:</i>
```sh
	$translation = new \WallRio\Solo\Translation();     
	echo $translation->go('Text to translate');		
```

<i>Example outlet:</i> 'Texto para traduzir'





+ <strong>goSimilar</strong>( Source = STRING )

>><i>description:</i> This method displays the translations similar to a word.

>><i>return:</i> (string)

>><i>example:</i>
```sh
	$translation = new \WallRio\Solo\Translation();     
	echo $translation->goSimilar('home');
```

>><i>Example outlet:</i> 'casa,inicio,moradia'





+ <strong>stylefont</strong>( STYLE = STRING )

>><i>description:</i> This method is used to format globally as the translated text.

>><i>return:</i> (void) este método não tem retorno

>><i>example:</i>
	```sh
		$translation = new \WallRio\Solo\Translation();  
		$translation->stylefont('ucfirst:true;ucwords:false');
	```






+ <strong>listLanguages</strong>()

>><i>description:</i> This method is used to list the languages ​​available.

>><i>return:</i> (array)

>><i>example:</i>
	```sh
		$translation = new \WallRio\Solo\Translation();  
		$translation->listLanguages();
		var_dump($translation);
	```





+ <strong>setLanguageTo</strong>( langaguePrefix = STRING )

>><i>description:</i> This method is used to choose the target language of the translation.

>><i>return:</i> (void)

>><i>example:</i>
	```sh
		$translation = new \WallRio\Solo\Translation();  
		$translation->setLanguageTo('ptbr');		
	```







+ <strong>setLanguageFrom</strong>( langaguePrefix = STRING )

>><i>description:</i> This method is used to choose the source language of the translation.

>><i>return:</i> (void)

>><i>example:</i>
	```sh
		$translation = new \WallRio\Solo\Translation();  
		$translation->setLanguageFrom('ptbr');		
	```







+ <strong>getLanguageNameTo</strong>()

>><i>description:</i> This method is used to capture the name of the target language translation.

>><i>return:</i> (string)

>><i>example:</i>
	```sh
		$translation = new \WallRio\Solo\Translation();  
		echo $translation->getLanguageNameTo();		
	```
