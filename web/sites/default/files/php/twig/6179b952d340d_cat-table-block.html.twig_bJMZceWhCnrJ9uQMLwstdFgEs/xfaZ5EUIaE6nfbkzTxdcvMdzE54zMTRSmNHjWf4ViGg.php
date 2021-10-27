<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/custom/evilargest/templates/cat-table-block.html.twig */
class __TwigTemplate_3559569b882949c00a73c9f643fed8b5e2ad7b1c5c7dd4bdee75625415e0ccf3 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div class=\"table_cat\">
  <div class=\"cat_info\">
    <p class=\"cat_table_name\">";
        // line 3
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["name"] ?? null), 3, $this->source), "html", null, true);
        echo "</p>
    <p class=\"cat_table_email\">";
        // line 4
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["email"] ?? null), 4, $this->source), "html", null, true);
        echo "</p>
    <p class=\"cat_table_date\">";
        // line 5
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["date"] ?? null), 5, $this->source), "html", null, true);
        echo "</p>
    ";
        // line 6
        if (twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "hasPermission", [0 => "administer nodes"], "method", false, false, true, 6)) {
            // line 7
            echo "      <div class=\"cat_table_buttons\">
        <div class=\"cat_button cat_table_edit\"><a href='/evilargest/editCat/";
            // line 8
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["id"] ?? null), 8, $this->source), "html", null, true);
            echo "/' class=\"use-ajax cat_table_link\" data-dialog-type=\"modal\">Edit</a></div>
        <div class=\"cat_button cat_table_delete\"><a href='/evilargest/deleteCat/";
            // line 9
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["id"] ?? null), 9, $this->source), "html", null, true);
            echo "/' class=\"use-ajax cat_table_link\" data-dialog-type=\"modal\">Delete</a></div>
      </div>
    ";
        }
        // line 12
        echo "  </div>
  <div class=\"image_wrapper\">";
        // line 13
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["image"] ?? null), 13, $this->source), "html", null, true);
        echo "</div>
</div>
";
    }

    public function getTemplateName()
    {
        return "modules/custom/evilargest/templates/cat-table-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  70 => 12,  64 => 9,  60 => 8,  57 => 7,  55 => 6,  51 => 5,  47 => 4,  43 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"table_cat\">
  <div class=\"cat_info\">
    <p class=\"cat_table_name\">{{ name }}</p>
    <p class=\"cat_table_email\">{{ email }}</p>
    <p class=\"cat_table_date\">{{ date }}</p>
    {% if user.hasPermission('administer nodes') %}
      <div class=\"cat_table_buttons\">
        <div class=\"cat_button cat_table_edit\"><a href='/evilargest/editCat/{{ id }}/' class=\"use-ajax cat_table_link\" data-dialog-type=\"modal\">Edit</a></div>
        <div class=\"cat_button cat_table_delete\"><a href='/evilargest/deleteCat/{{ id }}/' class=\"use-ajax cat_table_link\" data-dialog-type=\"modal\">Delete</a></div>
      </div>
    {% endif %}
  </div>
  <div class=\"image_wrapper\">{{ image }}</div>
</div>
", "modules/custom/evilargest/templates/cat-table-block.html.twig", "/var/www/web/modules/custom/evilargest/templates/cat-table-block.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 6);
        static $filters = array("escape" => 3);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
