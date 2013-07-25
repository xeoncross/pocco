<!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<title><?php print basename($file, '.php'); ?> - Pocco Documentation</title>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" media="all" href="style.css"/>

	<style type="text/css">
		/* 
		 * Orginal Style from ethanschoonover.com/solarized (c) Jeremy Hull <sourdrums@gmail.com>
		 */

		pre code {
			display: block; padding: 0.5em;
			background: #fdf6e3; color: #657b83;
		}

		pre .comment,
		pre .template_comment,
		pre .diff .header,
		pre .doctype,
		pre .pi,
		pre .lisp .string,
		pre .javadoc {
			color: #93a1a1;
			font-style: italic;
		}

		pre .keyword,
		pre .winutils,
		pre .method,
		pre .addition,
		pre .css .tag,
		pre .request,
		pre .status,
		pre .nginx .title {
			color: #859900;
		}

		pre .number,
		pre .command,
		pre .string,
		pre .tag .value,
		pre .rules .value,
		pre .phpdoc,
		pre .tex .formula,
		pre .regexp,
		pre .hexcolor {
			color: #2aa198;
		}

		pre .title,
		pre .localvars,
		pre .chunk,
		pre .decorator,
		pre .built_in,
		pre .identifier,
		pre .vhdl .literal,
		pre .id,
		pre .css .function {
			color: #268bd2;
		}

		pre .attribute,
		pre .variable,
		pre .lisp .body,
		pre .smalltalk .number,
		pre .constant,
		pre .class .title,
		pre .parent,
		pre .haskell .type {
			color: #b58900;
		}

		pre .preprocessor,
		pre .preprocessor .keyword,
		pre .shebang,
		pre .symbol,
		pre .symbol .string,
		pre .diff .change,
		pre .special,
		pre .attr_selector,
		pre .important,
		pre .subst,
		pre .cdata,
		pre .clojure .title,
		pre .css .pseudo {
			color: #cb4b16;
		}

		pre .deletion {
			color: #dc322f;
		}

		pre .tex .formula {
			background: #eee8d5;
		}

		/*--------------------- Layout and Typography ----------------------------*/

		body {
			font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, FreeSerif, serif;
			font-size: 15px;
			line-height: 22px;
			color: #252519;
			margin: 0; padding: 0;
		}

		a {
			color: #261a3b;
			text-decoration: none;
			font-weight: bold;
		}

		a:hover { text-decoration: underline; }

		a:visited {
			color: #261a3b;
		}

		p {
			margin: 0 0 15px 0;
		}

		h1, h2, h3, h4, h5, h6 {
			margin: 0px 0 15px 0;
		}

		h1 {
			margin-top: 40px;
		}

		#container {
			position: relative;
		}

		table { width: 100%; }

		table td {
			border: 0;
			outline: 0;
		}

		td.docs, th.docs {
			min-width: 300px;
			max-width: 50%;
			min-height: 5px;
			padding: 1em 2em;
			overflow-x: hidden;
			vertical-align: top;
			text-align: left;
			border-top: 1px solid #fff;
			border-bottom: 1px solid #E9E9F5;
		}

		.docs pre {
			/*
			white-space: pre-wrap;
			white-space: pre;
			*/
			margin: 15px 0 15px;
			padding-left: 15px;
			overflow: auto;
		}

		.docs p:last-child {
			margin: 0;
		}

		.docs p tt, .docs p code {
			background: #f8f8ff;
			border: 1px solid #dedede;
			font-size: 12px;
			padding: 0 0.2em;
		}

		.docs .doc ul {
			list-style: disc;
			margin: 0;
			padding: 1em 2em;
			background: #FFFBD3;
		}

		.pilwrap {
			position: relative;
		}

		.pilcrow {
			font: 12px Arial;
			text-decoration: none;
			color: #454545;
			position: absolute;
			top: 3px; left: -20px;
			padding: 1px 2px;
			opacity: 0;
			-webkit-transition: opacity 0.2s linear;
		}

		td.docs:hover .pilcrow {
			opacity: 1;
		}

		td.code, th.code {
			padding: 1em 1em;
			max-width: 50%;
			vertical-align: top;
			background: #fdf6e3; /* solarized tan */
			background: #f5f5ff;
			border-left: 1px solid #e5e5ee;
			border-top: 1px solid #fff;
			border-bottom: 1px solid #E9E9F5;
		}

		pre, tt, code {
			font-size: 14px; line-height: 18px;
			font-family:"DejaVu Sans Mono","Bitstream Vera Sans Mono",Monaco,"Courier New",monospace;
			margin: 0; padding: 0;
		}

		#jump_to, #jump_page {
			background: white;
			-webkit-box-shadow: 0 0 25px #777; -moz-box-shadow: 0 0 25px #777;
			-webkit-border-bottom-left-radius: 5px; -moz-border-radius-bottomleft: 5px;

			-webkit-box-shadow:	3px 3px 3px 0px rgba(0, 0, 0, .1);
			box-shadow:	3px 3px 3px 0px rgba(0, 0, 0, .1);

			font: 20px Arial;
			text-transform: uppercase;
			cursor: pointer;
			text-align: right;
		}

		#jump_to, #jump_wrapper {
			position: fixed;
			right: 0; top: 0;
			padding: 5px 10px;
		}

		#jump_wrapper {
			padding: 0;
			display: none;
		}

		#jump_to:hover #jump_wrapper {
			display: block;
		}

		#jump_page {
			padding: 5px 0 3px;
			margin: 0 0 25px 25px;
			overflow:hidden;
		}

		#jump_page .source, #jump_page span {
			display: block;
			padding: 5px 10px;
			text-decoration: none;
			border-top: 1px solid #eee;
			float:left;
			min-width:200px;
			text-align:left;
			text-transform:none;
			font-size:11px;
		}

		#jump_page .source:hover {
			background: #f5f5ff;
		}

		#jump_page .source:first-child {}

		ul {
			margin: 0;
			padding: 0;
			list-style: none;
		}


		#table-of-contents li:before {
			content: '\2B51';
			padding-right: 1em;
			color: #ccc;
		}

		#table-of-contents li:hover:before {
			color: #000;
		}

		.params { margin: 0 0 1em 0; }
		.params ul li { background: #eee; text-align: right; padding: .5em 1em; border-bottom: 1px solid #e3e3e3; }
		.params ul li span { float: left; color: #008 }
		.params ul li span i { color: #999; }

		pre .keyword, pre .id, pre .phpdoc, pre .title, pre .built_in, pre .aggregate, 
		pre .css .tag, pre .javadoctag, pre .phpdoc, pre .yardoctag, pre .smalltalk .class, 
		pre .winutils, pre .bash .variable, pre .apache .tag, pre .go .typename, pre .tex .command, 
		pre .markdown .strong, pre .request, pre .status {
			font-weight: normal;
		}

	</style>

	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://yandex.st/highlightjs/7.3/highlight.min.js"></script>
	<script type="text/javascript">
		<?php readfile(__DIR__ . '/markdown.js'); ?>
	</script>

	<script>
		$(function(){
			$(".doc").each(function() {
				$(this).html(markdown.toHTML($(this).text()));
			});

			$('pre').each(function(i, e) {
				hljs.highlightBlock(e);
			});
		});
	</script>
	
</head>
<body lang="en">
<div id="container">
	<div id="background"></div>
	
	<?php if($files):?>
		<div id="jump_to">
			Jump To &hellip;
			<div id="jump_wrapper">
				<div id="jump_page">
					<?php ksort($files); ?>
					<?php foreach($files as $path): ?>
						<a class="source" href="?file=<?php print rawurlencode($path); ?>"><?php print substr($path, 0, -4); ?></a>
					<?php endforeach?>
				</div>
			</div>
		</div>
	<?php endif?>

	<table cellspacing=0 cellpadding=0>
		<thead>
			<tr>
				<th class=docs>
					<h1><?php print basename($file, '.php'); ?></h1>
					<?php foreach ($sections as $count => $section) { ?>
						<ul id="table-of-contents">
						<?php if(isset($section['function'])) { ?>
							<li><a href="#section-<?php print $count; ?>"><?php print $section['function']; ?>()</a></li>
						<?php } ?>
						</ul>
					<?php } ?>
				</th>
				<th class=code></th>
			</tr>
		</thead>
	<tbody>
	<?php foreach ($sections as $count => $section) { ?>
		<tr id="section-<?php print $count; ?>">
			<td class="docs">
				<div class="pilwrap"><a class="pilcrow" href="#section-<?php print $count; ?>">&#182;</a></div>

				<?php if(isset($section['function'])) { ?>
					<h3><a href="#container"><?php print $section['function']; ?>()</a></h3>
				<?php } ?>

				<?php if(!empty($section['meta']['params'])) { ?>
					<div class="params">
						<?php if($section['meta']['params']) { ?>
							<ul>
								<?php foreach($section['meta']['params'] as $param) { ?>
									<!--<li><?php print join(' ', $param); ?></li>-->
									<li>
										<span><i><?php print $param['type']; ?></i> <?php print $param['name']; ?></span>
										&nbsp; <?php print $param['desc']; ?>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
				<?php } ?>

				<div class="doc"><?php print $section[0]; ?></div>

			</td>
			<td class="code">
				<div class="highlight">
					<pre class="php"><?php print htmlspecialchars(rtrim($section[1]), ENT_QUOTES, 'utf-8'); ?></pre>
				</div>
			</td>
		</tr>
	<?php } ?>
	</table>
</div>
</body>
</html>