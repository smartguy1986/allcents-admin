# tinymce-bootstrap-accordion
Bootstrap Accordion plugin for TinyMCE

This plugin allows users to create and edit Bootstrap accordions in TinyMCE. Each accordion can have a title and a togglable content section. It can also be set to be opened or closed by default.

##Usage
Clone this repo and place the whole thing in your TinyMCE "plugins" directory.

Then include the plugin in your initialization script, and add it to your toolbar. Something like this:

    tinymce.init({
      selector: "textarea",  // change this value according to your HTML
      plugins: ["bootstrapaccordion"],
      toolbar: 'undo redo | styleselect | bold italic | bootstrapaccordion'
    });

##Options
###Customize the editor within the editor
You may want to customize the editor inside the accordion dialog box. What it actually does is load an instance of TinyMCE *inside* TinyMCE. It's like TinyMCEption. Anywho, the inner editor is loaded in `dialog.html`. Feel free to open up that file and customize this editor within the editor.
