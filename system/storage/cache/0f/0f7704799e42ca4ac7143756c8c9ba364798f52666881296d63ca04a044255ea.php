<?php

/* common/header.twig */
class __TwigTemplate_c25c95cc0e0020223949006ec29958fc62ab0fd6838dd938df1660e968eb7717 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html dir=\"";
        // line 2
        echo (isset($context["direction"]) ? $context["direction"] : null);
        echo "\" lang=\"";
        echo (isset($context["lang"]) ? $context["lang"] : null);
        echo "\">
<head>
<meta charset=\"UTF-8\" />
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0\" />
<title>";
        // line 6
        echo (isset($context["title"]) ? $context["title"] : null);
        echo "</title>
<base href=\"";
        // line 7
        echo (isset($context["base"]) ? $context["base"] : null);
        echo "\" />
";
        // line 8
        if ((isset($context["description"]) ? $context["description"] : null)) {
            // line 9
            echo "<meta name=\"description\" content=\"";
            echo (isset($context["description"]) ? $context["description"] : null);
            echo "\" />
";
        }
        // line 11
        if ((isset($context["keywords"]) ? $context["keywords"] : null)) {
            // line 12
            echo "<meta name=\"keywords\" content=\"";
            echo (isset($context["keywords"]) ? $context["keywords"] : null);
            echo "\" />
";
        }
        // line 14
        echo "<link rel=\"shortcut icon\" href=\"#\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"view/javascript/font-awesome/css/font-awesome.min.css\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"view/stylesheet/bootstrap.css\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"view/stylesheet/stylesheet.css\" media=\"screen\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css\" media=\"screen\" />
";
        // line 19
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["styles"]) ? $context["styles"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["style"]) {
            // line 20
            echo "<link rel=\"";
            echo $this->getAttribute($context["style"], "rel", array());
            echo "\" type=\"text/css\" href=\"";
            echo $this->getAttribute($context["style"], "href", array());
            echo "\" media=\"";
            echo $this->getAttribute($context["style"], "media", array());
            echo "\" />
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['style'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 22
        echo "<script type=\"text/javascript\" src=\"view/javascript/jquery/jquery-2.2.4.min.js\"></script>
<script type=\"text/javascript\" src=\"view/javascript/bootstrap/js/bootstrap.min.js\"></script>
<script type=\"text/javascript\" src=\"view/javascript/jquery/datetimepicker/moment/moment.min.js\"></script>
<script type=\"text/javascript\" src=\"view/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js\"></script>
<script type=\"text/javascript\" src=\"view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js\"></script>
";
        // line 27
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["links"]) ? $context["links"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 28
            echo "<link rel=\"";
            echo $this->getAttribute($context["link"], "rel", array());
            echo "\" href=\"";
            echo $this->getAttribute($context["link"], "href", array());
            echo "\" />
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        echo "<script type=\"text/javascript\" src=\"view/javascript/common.js\"></script>
";
        // line 31
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["scripts"]) ? $context["scripts"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["script"]) {
            // line 32
            echo "<script type=\"text/javascript\" src=\"";
            echo $context["script"];
            echo "\"></script>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['script'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "</head>
<body>
<div id=\"container\">
<header id=\"header\" class=\"navbar navbar-static-top\">
  <div class=\"container-fluid\">
    <div id=\"header-logo\" class=\"navbar-header\"><a href=\"";
        // line 39
        echo (isset($context["home"]) ? $context["home"] : null);
        echo "\" class=\"navbar-brand\"><img src=\"view/image/logo.png\" alt=\"";
        echo (isset($context["heading_title"]) ? $context["heading_title"] : null);
        echo "\" title=\"";
        echo (isset($context["heading_title"]) ? $context["heading_title"] : null);
        echo "\" /></a></div>
    ";
        // line 40
        if ((isset($context["logged"]) ? $context["logged"] : null)) {
            // line 41
            echo "    <a href=\"#\" id=\"button-menu\" class=\"hidden-md hidden-lg\"><span class=\"fa fa-bars\"></span></a>
    <ul class=\"nav navbar-nav navbar-right\">
      <li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><img src=\"";
            // line 43
            echo (isset($context["image"]) ? $context["image"] : null);
            echo "\" alt=\"";
            echo (isset($context["firstname"]) ? $context["firstname"] : null);
            echo " ";
            echo (isset($context["lastname"]) ? $context["lastname"] : null);
            echo "\" title=\"";
            echo (isset($context["username"]) ? $context["username"] : null);
            echo "\" id=\"user-profile\" class=\"img-circle\" />";
            echo (isset($context["firstname"]) ? $context["firstname"] : null);
            echo " ";
            echo (isset($context["lastname"]) ? $context["lastname"] : null);
            echo " <i class=\"fa fa-caret-down fa-fw\"></i></a>
        <ul class=\"dropdown-menu dropdown-menu-right\">
          <li><a href=\"";
            // line 45
            echo (isset($context["profile"]) ? $context["profile"] : null);
            echo "\"><i class=\"fa fa-user-circle-o fa-fw\"></i> ";
            echo (isset($context["text_profile"]) ? $context["text_profile"] : null);
            echo "</a></li>
          <li role=\"separator\" class=\"divider\"></li>
          <li class=\"dropdown-header\">";
            // line 47
            echo (isset($context["text_store"]) ? $context["text_store"] : null);
            echo "</li>
          ";
            // line 48
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["stores"]) ? $context["stores"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["store"]) {
                // line 49
                echo "          <li><a href=\"";
                echo $this->getAttribute($context["store"], "href", array());
                echo "\" target=\"_blank\">";
                echo $this->getAttribute($context["store"], "name", array());
                echo "</a></li>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['store'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 51
            echo "          <li role=\"separator\" class=\"divider\"></li>
          <li class=\"dropdown-header\">";
            // line 52
            echo (isset($context["text_help"]) ? $context["text_help"] : null);
            echo "</li>
          <li><a href=\"https://www.opencartbrasil.com.br\" target=\"_blank\"><i class=\"fa fa-opencart fa-fw\"></i> ";
            // line 53
            echo (isset($context["text_homepage"]) ? $context["text_homepage"] : null);
            echo "</a></li>
          <li><a href=\"http://docs.opencart.com\" target=\"_blank\"><i class=\"fa fa-file-text-o fa-fw\"></i> ";
            // line 54
            echo (isset($context["text_documentation"]) ? $context["text_documentation"] : null);
            echo "</a></li>
          <li><a href=\"https://forum.opencartbrasil.com.br\" target=\"_blank\"><i class=\"fa fa-comments-o fa-fw\"></i> ";
            // line 55
            echo (isset($context["text_support"]) ? $context["text_support"] : null);
            echo "</a></li>
        </ul>
      </li>
      <li><a href=\"";
            // line 58
            echo (isset($context["logout"]) ? $context["logout"] : null);
            echo "\"><i class=\"fa fa-sign-out\"></i> <span class=\"hidden-xs hidden-sm hidden-md\">";
            echo (isset($context["text_logout"]) ? $context["text_logout"] : null);
            echo "</span></a></li>
    </ul>
    ";
        }
        // line 61
        echo "  </div>
</header>
";
    }

    public function getTemplateName()
    {
        return "common/header.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  208 => 61,  200 => 58,  194 => 55,  190 => 54,  186 => 53,  182 => 52,  179 => 51,  168 => 49,  164 => 48,  160 => 47,  153 => 45,  138 => 43,  134 => 41,  132 => 40,  124 => 39,  117 => 34,  108 => 32,  104 => 31,  101 => 30,  90 => 28,  86 => 27,  79 => 22,  66 => 20,  62 => 19,  55 => 14,  49 => 12,  47 => 11,  41 => 9,  39 => 8,  35 => 7,  31 => 6,  22 => 2,  19 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html dir="{{ direction }}" lang="{{ lang }}">*/
/* <head>*/
/* <meta charset="UTF-8" />*/
/* <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />*/
/* <title>{{ title }}</title>*/
/* <base href="{{ base }}" />*/
/* {% if description %}*/
/* <meta name="description" content="{{ description }}" />*/
/* {% endif %}*/
/* {% if keywords %}*/
/* <meta name="keywords" content="{{ keywords }}" />*/
/* {% endif %}*/
/* <link rel="shortcut icon" href="#" />*/
/* <link rel="stylesheet" type="text/css" href="view/javascript/font-awesome/css/font-awesome.min.css" />*/
/* <link rel="stylesheet" type="text/css" href="view/stylesheet/bootstrap.css" />*/
/* <link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" media="screen" />*/
/* <link rel="stylesheet" type="text/css" href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" media="screen" />*/
/* {% for style in styles %}*/
/* <link rel="{{ style.rel }}" type="text/css" href="{{ style.href }}" media="{{ style.media }}" />*/
/* {% endfor %}*/
/* <script type="text/javascript" src="view/javascript/jquery/jquery-2.2.4.min.js"></script>*/
/* <script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>*/
/* <script type="text/javascript" src="view/javascript/jquery/datetimepicker/moment/moment.min.js"></script>*/
/* <script type="text/javascript" src="view/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js"></script>*/
/* <script type="text/javascript" src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js"></script>*/
/* {% for link in links %}*/
/* <link rel="{{ link.rel }}" href="{{ link.href }}" />*/
/* {% endfor %}*/
/* <script type="text/javascript" src="view/javascript/common.js"></script>*/
/* {% for script in scripts %}*/
/* <script type="text/javascript" src="{{ script }}"></script>*/
/* {% endfor %}*/
/* </head>*/
/* <body>*/
/* <div id="container">*/
/* <header id="header" class="navbar navbar-static-top">*/
/*   <div class="container-fluid">*/
/*     <div id="header-logo" class="navbar-header"><a href="{{ home }}" class="navbar-brand"><img src="view/image/logo.png" alt="{{ heading_title }}" title="{{ heading_title }}" /></a></div>*/
/*     {% if logged %}*/
/*     <a href="#" id="button-menu" class="hidden-md hidden-lg"><span class="fa fa-bars"></span></a>*/
/*     <ul class="nav navbar-nav navbar-right">*/
/*       <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ image }}" alt="{{ firstname }} {{ lastname }}" title="{{ username }}" id="user-profile" class="img-circle" />{{ firstname }} {{ lastname }} <i class="fa fa-caret-down fa-fw"></i></a>*/
/*         <ul class="dropdown-menu dropdown-menu-right">*/
/*           <li><a href="{{ profile }}"><i class="fa fa-user-circle-o fa-fw"></i> {{ text_profile }}</a></li>*/
/*           <li role="separator" class="divider"></li>*/
/*           <li class="dropdown-header">{{ text_store }}</li>*/
/*           {% for store in stores %}*/
/*           <li><a href="{{ store.href }}" target="_blank">{{ store.name }}</a></li>*/
/*           {% endfor %}*/
/*           <li role="separator" class="divider"></li>*/
/*           <li class="dropdown-header">{{ text_help }}</li>*/
/*           <li><a href="https://www.opencartbrasil.com.br" target="_blank"><i class="fa fa-opencart fa-fw"></i> {{ text_homepage }}</a></li>*/
/*           <li><a href="http://docs.opencart.com" target="_blank"><i class="fa fa-file-text-o fa-fw"></i> {{ text_documentation }}</a></li>*/
/*           <li><a href="https://forum.opencartbrasil.com.br" target="_blank"><i class="fa fa-comments-o fa-fw"></i> {{ text_support }}</a></li>*/
/*         </ul>*/
/*       </li>*/
/*       <li><a href="{{ logout }}"><i class="fa fa-sign-out"></i> <span class="hidden-xs hidden-sm hidden-md">{{ text_logout }}</span></a></li>*/
/*     </ul>*/
/*     {% endif %}*/
/*   </div>*/
/* </header>*/
/* */
