⛔️ DEPRECATED ⛔️

# Formstack plugin for Craft CMS 3.x

Plugin to integrate Formstack forms.

<img src="./resources/img/formstack-logo.svg" width="300" height="53" alt="Formstack Logo">

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require milesherndon/formstack

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Formstack.

## Formstack Overview

This plugin has a Formstack Form fieldtype which allows the selection of forms. The field pulls the forms directly from the associated account.

Also, when the field is displayed, it provides the JSON returned from Formstack for the selected form.

## Configuring Formstack

Once installed, go to Settings -> Formstack and save the oAuth token. This token can be found in the API settings within the Formstack account.

## Using Formstack

**Field Type**

Create a field and select the Formstack Form field type.

**Display Form**

Set a form variable with the data returned form formstack.

```{% set formstack = craft.formstack.getFormById(entry.contactForm) %}```

By default, only fields are returned in the response. However, extra items can be returned by adding them as a second parameter like below:

```{% set formstack = craft.formstack.getFormById(entry.contactForm, ['viewkey', 'name']) %}```

This will pass the viewkey and the name in the response as well. To see what else can be returned, view the [API documentation here](https://developers.formstack.com/docs/form-id-get).

**Example Template**

```
{% set formstack = craft.formstack.getFormById(entry.contactForm, ['viewkey']) %}

    {% if formstack is defined %}

        <form method="post" novalidate action="" id="fsForm{{entry.contactForm}}" class="contact__form__form form__form js-form fsForm" >
            <input type="hidden" name="action" value="formstack/form-submit" />
            <input type="hidden" name="redirect" value="{{ entry.getUrl() }}" />
            <input type="hidden" name="success" value="Thanks for your message, we will be in touch soon." />
            <input type="hidden" name="form" value="{{entry.contactForm}}" />
            <input type="hidden" name="viewkey" value="{{formstack.viewkey}}" />
            <input type="hidden" name="hidden_fields" id="hidden_fields{{entry.contactForm}}" value="" />
            <input type="hidden" name="_submit" value="1" />
            <input type="hidden" name="incomplete" id="incomplete{{entry.contactForm}}" value="" />
            <input type="hidden" id="viewparam" name="viewparam" value="636555" />
            <input type="hidden" id="analytics" name="analytics" value="https://analytics.formstack.com">
            <input type="hidden" name="{{ craft.app.config.general.csrfTokenName }}" value="{{ craft.app.request.csrfToken }}">

            <div class="fsPage" id="fsPage{{entry.contactForm}}-1">
                {% for field in formstack.fields %}
                    <div class="form__input-wrapper fsCell fsFieldCell" id="fsCell{{field.id}}">
                        {% if field.type == "name" or field.type == "text" or field.type == "email" or field.type == "phone" %}
                            {% if field.placeholder is defined and field.placeholder is not empty %}
                                {% set placeholder = field.placeholder %}
                            {% else %}
                                {% set placeholder = field.label %}
                            {% endif %}
                            <input type="{{field.type}}" id="field{{field.id}}" name="field_{{field.id}}" class="fsField{% if field.required %} fsRequired required{% endif %}" {% if field.required %}aria-required="true" required="required"{% endif %} placeholder="{{placeholder}}"/>
                            <label for="field{{field.id}}">{{field.label}} {% if field.required %} <span>*</span>{% endif %}</label>
                        {% endif %}
                        {% if field.type == "textarea" %}
                            <textarea id="field{{field.id}}" name="field_{{field.id}}" class="fsField{% if field.required %} fsRequired required{% endif %}" {% if field.required %}aria-required="true" required="required"{% endif %} placeholder=""></textarea>
                            <label for="field{{field.id}}">{{field.label}} {% if field.required %} <span>*</span>{% endif %}</label>
                        {% endif %}
                        {% if field.type == "select" %}
                            <div class="select-box">
                                <select id="field{{field.id}}" name="field_{{field.id}}" class="fsField{% if field.required %} fsRequired required{% endif %}" {% if field.required %}aria-required="true" required="required"{% endif %}>
                                    <option value="" disabled selected>Choose One</option>
                                    {% for option in field.options %}
                                        <option value="{{option.value}}">{{option.label}}</option>
                                    {% endfor %}
                                </select>
                            </div>
                            <label id="label{{field.id}}" for="field{{field.id}}">{{field.label}} {% if field.required %} <span>*</span>{% endif %}</label>
                        {% endif %}
                    </div>
                {% endfor %}
            </div>

            <div id="fsSubmit{{entry.contactForm}}" class="fsSubmit">
                <input type="submit" id="fsSubmitButton{{entry.contactForm}}" class="fsSubmitButton" value="Submit" />
            </div>
        </form>
    {% endif %}
```

## Formstack Roadmap

* Add extra checks to verify if form exists
* Allow for default form selection
* Add default templating
* Add caching of Formstack responses

Brought to you by [MilesHerndon](https://milesherndon.com)
