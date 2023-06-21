<?php

/* common/footer.twig */
class __TwigTemplate_f5cf59353cbcff73f68d7484423c989a8168b5cd657f6bcdab8d6d6ba7b6db0c extends Twig_Template
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
        echo "<footer id=\"footer\">";
        echo (isset($context["text_footer"]) ? $context["text_footer"] : null);
        echo "<br/>";
        echo (isset($context["text_version"]) ? $context["text_version"] : null);
        echo "</footer></div>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "common/footer.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
/* <footer id="footer">{{ text_footer }}<br/>{{ text_version }}</footer></div>*/
/* </body>*/
/* </html>*/
