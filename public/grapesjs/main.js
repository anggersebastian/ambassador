localStorage.setItem('storage_removed', "1");
window.history.pushState("object or string", "Title", $('base').data('url') + '/backend/landing/builder/' + $('base').data('landing-id'));

var lp = './img/';
var plp = '//placehold.it/350x250/';
var images = [];

var editor  = grapesjs.init({
    avoidInlineStyle: 1,
    height: '100%',
    allowScripts: 1,
    storageManager: {
        id: 'gjs-',             // Prefix identifier that will be used inside storing and loading
        type: 'local',          // Type of the storage
        autosave: true,         // Store data automatically
        autoload: false,         // Autoload stored data on init
        stepsBeforeSave: 1,     // If autosave enabled, indicates how many changes are necessary before store method is triggered
        storeComponents: true, // Enable/Disable storing of components in JSON format
        storeStyles: true,     // Enable/Disable storing of rules/style in JSON format
        storeHtml: true,        // Enable/Disable storing of components as HTML string
        storeCss: true,         // Enable/Disable storing of rules/style as CSS string
    },
    container : '#gjs',
    fromElement: 1,
    showOffsets: 1,
    assetManager: {
        upload: $('base').data('url') + '/backend/landing/upload-asset?_token=' + $('base').data('csrf'),
        assets: images
    },
    styleManager: { clearProperties: 1 },
    protectedCss: $('base').data('css'),
    cssComposer: {

    },
    plugins: [
        'gjs-plugin-ckeditor',
        'gjs-preset-webpage',
        'grapesjs-tabs',
        'grapesjs-custom-code',
        'grapesjs-touch',
        'grapesjs-parser-postcss',
        'grapesjs-tooltip',
        'grapesjs-tui-image-editor',
        'grapesjs-typed',
        'gjs-blocks-basic',
        defaultButton,
        youtubeVideo,
        divider
    ],
    pluginsOpts: {
        "gjs-blocks-basic": {
            blocks: ['column1', 'column2', 'column3', 'column3-7', 'text', 'link', 'image', 'map'],

        },
        'gjs-plugin-ckeditor': {
            options: {
                language: 'en',
                toolbar: [
                    { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                    { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                    { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                    '/',
                    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                    { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                    '/',
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                    { name: 'about', items: [ 'About' ] }
                ]
            },
            position: 'center',
            uiColor: '#AADC6E'
        },
        'grapesjs-tui-image-editor': {
            config: {
                includeUI: {
                    initMenu: 'filter',
                },
            },
            /*onApply: function(imageEditor, imageModel){
                console.log(imageEditor);
                console.log(imageModel);
            },*/
            upload: $('base').data('url') + '/backend/landing/upload-asset?type=blob&_token=' + $('base').data('csrf'),
        },
        'gjs-component-countdown': {
            labelDays: 'Hari',
            labelHours: 'Jam',
            labelMinutes: 'Menit',
            labelSeconds: 'Detik'
        },
        'grapesjs-lory-slider': {
            sliderBlock: {
                category: 'Extra'
            }
        },
        'grapesjs-tabs': {
            tabsBlock: {
                category: 'Extra'
            }
        },
        'grapesjs-typed': {
            block: {
                category: 'Extra',
                content: {
                    type: 'typed',
                    'type-speed': 40,
                    strings: [
                        'Text row one',
                        'Text row two',
                        'Text row three',
                    ],
                }
            }
        }
    },

});

var pn = editor.Panels;
var modal = editor.Modal;
var cmdm = editor.Commands;
cmdm.add('canvas-clear', function() {
    if(confirm('Are you sure to clean the canvas?')) {
        var comps = editor.DomComponents.clear();
        setTimeout(function(){ localStorage.clear()}, 0)
    }
});
cmdm.add('set-device-desktop', {
    run: function(ed) { ed.setDevice('Desktop') },
    stop: function() {},
});
cmdm.add('set-device-tablet', {
    run: function(ed) { ed.setDevice('Tablet') },
    stop: function() {},
});
cmdm.add('set-device-mobile', {
    run: function(ed) { ed.setDevice('Mobile portrait') },
    stop: function() {},
});



// Add info command
var mdlClass = 'gjs-mdl-dialog-sm';
var infoContainer = document.getElementById('info-panel');
cmdm.add('open-info', function() {
    var mdlDialog = document.querySelector('.gjs-mdl-dialog');
    mdlDialog.className += ' ' + mdlClass;
    infoContainer.style.display = 'block';
    modal.setTitle('About this demo');
    modal.setContent(infoContainer);
    modal.open();
    modal.getModel().once('change:open', function() {
        mdlDialog.className = mdlDialog.className.replace(mdlClass, '');
    })
});
pn.addButton('options', {
    id: 'open-info',
    className: 'fa fa-save',
    command: function() {
        let finalHtml   = editor.getHtml();
        let finalCss    = editor.getCss();
        $.ajax({
            type: 'POST',
            url:  $('base').data('url') + '/backend/landing/save',
            data: {
                id: $('base').data('landing-id'),
                _token: $('base').data('csrf'),
                user_id: $('base').data('user-id'),
                html: finalHtml,
                css: finalCss
            },
            beforeSend: function() {

            },
            success: function(data) {
                alert(data.message);
            },
            error: function(xhr) { // if error occured
                alert("Error occured.please reload your page and try again");
            }
        });
    },
    attributes: {
        'title': 'Save',
        'data-tooltip-pos': 'bottom',
    },
});


// Simple warn notifier
var origWarn = console.warn;
toastr.options = {
    closeButton: true,
    preventDuplicates: true,
    showDuration: 250,
    hideDuration: 150
};
console.warn = function (msg) {
    if (msg.indexOf('[undefined]') == -1) {
        toastr.warning(msg);
    }
    origWarn(msg);
};


// Add and beautify tooltips
[['sw-visibility', 'Show Borders'], ['preview', 'Preview'], ['fullscreen', 'Fullscreen'],
    ['export-template', 'Export'], ['undo', 'Undo'], ['redo', 'Redo'], ['canvas-clear', 'Clear canvas']]
    .forEach(function(item) {
        pn.getButton('options', item[0]).set('attributes', {title: item[1], 'data-tooltip-pos': 'bottom'});
    });
[['open-sm', 'Style Manager'], ['open-layers', 'Layers'], ['open-blocks', 'Blocks']]
    .forEach(function(item) {
        pn.getButton('views', item[0]).set('attributes', {title: item[1], 'data-tooltip-pos': 'bottom'});
    });
var titles = document.querySelectorAll('*[title]');

for (var i = 0; i < titles.length; i++) {
    var el = titles[i];
    var title = el.getAttribute('title');
    title = title ? title.trim(): '';
    if(!title)
        break;
    el.setAttribute('data-tooltip', title);
    el.setAttribute('title', '');
}
const domComponents = editor.DomComponents;

// Show borders by default
pn.getButton('options', 'sw-visibility').set('active', 1);


// Store and load events
editor.on('storage:load', function(e) {
    console.log('Loaded ', e);
});
editor.on('storage:store', function(e) {
    //console.log(e.css);
});

editor.on('asset:upload:start', () => {

});

// The upload is ended (completed or not)
editor.on('asset:upload:end', () => {

});

// Error handling
editor.on('asset:upload:error', (err) => {

});

editor.on('block:drag:stop', (ev, result) => {
    if(typeof ev === 'undefined' || typeof ev.attributes === 'undefined'){
        return;
    }

    if(ev.attributes.tagName === 'img'){
        //editor.setStyle('#' + ev.ccid + '{width: 100%}');
        var sm      = editor.SelectorManager;
        var imgCss  = sm.add('#' + ev.ccid);
        var rule = cssComposer.add([imgCss]);
        rule.set('style', {
            width: '100%',
            'max-width':'350px'
        });

    }


    if(ev.attributes.tagName === 'div' && ev.attributes.name == 'Row'){

        var sm          = editor.SelectorManager;
        var parentCss   = sm.add('#' + ev.ccid);
        var rule        = cssComposer.add([parentCss]);
        rule.set('style', {
            "text-align": 'center',
            height: "150px",
            padding: "10px"
        });

        var childCss    = sm.add('#' + ev.ccid + ' .cell');
        var rule2       = cssComposer.add([childCss]);
        rule2.set('style', {
            "text-align": 'center',
            height: "100%"
        });
        //editor.setStyle('#' + ev.ccid + '{text-align: center; height:150px;padding:10px} ' + '#' + ev.ccid + ' .cell{text-align: center; height:100%;}');
    }
});

// Do something on response
editor.on('asset:upload:response', (response, ev) => {
    console.log(ev);
    let am = editor.AssetManager;
    if(response.status === true){
        editor.runCommand('open-assets', {
            target: editor.getSelected()
        });
        am.add([
            {
                category:'default',
                src: response.image
            }
        ]);
    }
});


let am = editor.AssetManager;
$.ajax({
    type: 'GET',
    url:  $('base').data('url') + '/backend/landing/list-assets',
    beforeSend: function() {

    },
    success: function(data) {
        let imagesLoad  = [];
        if(data.status === true){
            $.each(data.files, function (k, obj) {
                imagesLoad.push({
                    category: 'default',
                    src: obj
                });
            });
        }
        console.log(imagesLoad);
        am.add(imagesLoad);
    },
    error: function(xhr) { // if error occured
        alert("Error occured.please reload your page and try again");
    }
});


// Do stuff on load
editor.on('load', function() {
    var $ = grapesjs.$;

    // Show logo with the version
    var logoCont = document.querySelector('.gjs-logo-cont');
    document.querySelector('.gjs-logo-version').innerHTML = 'v' + grapesjs.version;
    var logoPanel = document.querySelector('.gjs-pn-commands');
    //logoPanel.appendChild(logoCont);


    // Load and show settings and style manager
    var openTmBtn = pn.getButton('views', 'open-tm');
    openTmBtn && openTmBtn.set('active', 1);
    var openSm = pn.getButton('views', 'open-sm');
    openSm && openSm.set('active', 1);

    // Add Settings Sector
    var traitsSector = $('<div class="gjs-sm-sector no-select">'+
        '<div class="gjs-sm-title"><span class="icon-settings fa fa-cog"></span> Settings</div>' +
        '<div class="gjs-sm-properties" style="display: none;"></div></div>');
    var traitsProps = traitsSector.find('.gjs-sm-properties');
    traitsProps.append($('.gjs-trt-traits'));
    $('.gjs-sm-sectors').before(traitsSector);
    traitsSector.find('.gjs-sm-title').on('click', function(){
        var traitStyle = traitsProps.get(0).style;
        var hidden = traitStyle.display == 'none';
        if (hidden) {
            traitStyle.display = 'block';
        } else {
            traitStyle.display = 'none';
        }
    });

    // Open block manager
    var openBlocksBtn = editor.Panels.getButton('views', 'open-blocks');
    openBlocksBtn && openBlocksBtn.set('active', 1);
});


// add button by alan
const cssComposer = editor.CssComposer;
var sm      = editor.SelectorManager;
var btnBuy  = sm.add('btn-buy');
var rule    = cssComposer.add([btnBuy]);
rule.set('style', {
    'background-color':'red',
    'text-decoration': 'none',
    'padding': '20px',
    'font-size': '24px',
    'border': '2px solid #00ffcf',
    color: '#fff',
});
const bm = editor.BlockManager;
bm.get('default-button').set('category', 'Basic');
bm.get('youtube-video').set('category', 'Basic');
bm.get('divider').set('category', 'Basic');

const panelManager = editor.Panels;
var myPanel = panelManager.getPanel('info-panel');
var button = panelManager.getButton('download','myButton');

editor.BlockManager.getAll().remove('video');
editor.BlockManager.getAll().remove('radio');
editor.BlockManager.getAll().remove('checkbox');
editor.BlockManager.getAll().remove('label');
editor.BlockManager.getAll().remove('button');
editor.BlockManager.getAll().remove('select');
editor.BlockManager.getAll().remove('textarea');
editor.BlockManager.getAll().remove('input');
editor.BlockManager.getAll().remove('form');

function defaultButton(editor){
    editor.BlockManager.add('default-button', {
        label: '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path d="M10 19.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5zm3.5-1.5c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5zm1.336-5l1.977-7h-16.813l2.938 7h11.898zm4.969-10l-3.432 12h-12.597l.839 2h13.239l3.474-12h1.929l.743-2h-4.195z"/></svg>' +
            '<br/>BUY Button',
        content: '<br/><br/><a href="#" class="btn btn-buy">BELI SEKARANG</a>',
    });
}

function youtubeVideo(editor) {
    editor.BlockManager.add('youtube-video', {
        label: '<?xml version="1.0"?><svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50px" height="50px">    <path d="M 5.6796875 2 L 7.1582031 7.34375 L 7.1582031 9.90625 L 8.4394531 9.90625 L 8.4394531 7.34375 L 9.9375 2 L 8.6464844 2 L 8.109375 4.4316406 C 7.958375 5.1416406 7.8623594 5.6462656 7.8183594 5.9472656 L 7.7792969 5.9472656 C 7.7162969 5.5262656 7.6202813 5.017875 7.4882812 4.421875 L 6.9707031 2 L 5.6796875 2 z M 11.431641 4.0175781 C 10.997641 4.0175781 10.647859 4.1023906 10.380859 4.2753906 C 10.113859 4.4473906 9.9170156 4.7226094 9.7910156 5.0996094 C 9.6660156 5.4766094 9.6035156 5.9756563 9.6035156 6.5976562 L 9.6035156 7.4375 C 9.6035156 8.0525 9.6575781 8.5450156 9.7675781 8.9160156 C 9.8775781 9.2870156 10.063219 9.5603281 10.324219 9.7363281 C 10.585219 9.9123281 10.944344 10 11.402344 10 C 11.848344 10 12.202891 9.9132344 12.462891 9.7402344 C 12.722891 9.5672344 12.911344 9.295875 13.027344 8.921875 C 13.143344 8.547875 13.201172 8.0535 13.201172 7.4375 L 13.201172 6.5976562 C 13.201172 5.9766562 13.142437 5.4794687 13.023438 5.1054688 C 12.904438 4.7324687 12.715031 4.45725 12.457031 4.28125 C 12.199031 4.10525 11.858641 4.0175781 11.431641 4.0175781 z M 13.878906 4.1308594 L 13.878906 8.4453125 C 13.878906 8.9793125 13.968391 9.3720469 14.150391 9.6230469 C 14.332391 9.8740469 14.615047 10 14.998047 10 C 15.550047 10 15.966187 9.7332188 16.242188 9.1992188 L 16.269531 9.1992188 L 16.382812 9.90625 L 17.400391 9.90625 L 17.400391 4.1308594 L 16.101562 4.1308594 L 16.101562 8.71875 C 16.051563 8.82575 15.975094 8.9134219 15.871094 8.9824219 C 15.767094 9.0524219 15.659875 9.0859375 15.546875 9.0859375 C 15.414875 9.0859375 15.320672 9.031875 15.263672 8.921875 C 15.206672 8.811875 15.177734 8.6271406 15.177734 8.3691406 L 15.177734 4.1308594 L 13.878906 4.1308594 z M 11.402344 4.9121094 C 11.584344 4.9121094 11.713156 5.0072187 11.785156 5.1992188 C 11.857156 5.3902187 11.892578 5.694375 11.892578 6.109375 L 11.892578 7.9082031 C 11.892578 8.3352031 11.857156 8.6440312 11.785156 8.8320312 C 11.713156 9.0200312 11.585297 9.1142344 11.404297 9.1152344 C 11.222297 9.1152344 11.096344 9.0200313 11.027344 8.8320312 C 10.957344 8.6440313 10.923828 8.3352031 10.923828 7.9082031 L 10.923828 6.109375 C 10.923828 5.695375 10.95925 5.3912188 11.03125 5.1992188 C 11.10325 5.0082187 11.226344 4.9121094 11.402344 4.9121094 z M 5 11 C 3.9 11 3 11.9 3 13 L 3 20 C 3 21.1 3.9 22 5 22 L 19 22 C 20.1 22 21 21.1 21 20 L 21 13 C 21 11.9 20.1 11 19 11 L 5 11 z M 12.048828 13 L 13.105469 13 L 13.105469 15.568359 L 13.113281 15.568359 C 13.208281 15.382359 13.344531 15.233141 13.519531 15.119141 C 13.694531 15.005141 13.883938 14.949219 14.085938 14.949219 C 14.345937 14.949219 14.549266 15.01825 14.697266 15.15625 C 14.845266 15.29425 14.953531 15.517219 15.019531 15.824219 C 15.085531 16.132219 15.117187 16.559469 15.117188 17.105469 L 15.117188 17.876953 L 15.119141 17.876953 C 15.119141 18.603953 15.030469 19.136516 14.855469 19.478516 C 14.680469 19.820516 14.408109 19.992188 14.037109 19.992188 C 13.830109 19.992188 13.642656 19.944609 13.472656 19.849609 C 13.302656 19.754609 13.174844 19.623984 13.089844 19.458984 L 13.066406 19.458984 L 12.955078 19.919922 L 12.048828 19.919922 L 12.048828 13 z M 5.4863281 13.246094 L 8.7382812 13.246094 L 8.7382812 14.130859 L 7.6484375 14.130859 L 7.6484375 19.919922 L 6.5761719 19.919922 L 6.5761719 14.130859 L 5.4863281 14.130859 L 5.4863281 13.246094 z M 17.097656 14.951172 C 17.473656 14.951172 17.762844 15.020203 17.964844 15.158203 C 18.165844 15.296203 18.307625 15.511734 18.390625 15.802734 C 18.472625 16.094734 18.513672 16.497719 18.513672 17.011719 L 18.513672 17.847656 L 16.677734 17.847656 L 16.677734 18.095703 C 16.677734 18.408703 16.686078 18.642828 16.705078 18.798828 C 16.724078 18.954828 16.762312 19.069625 16.820312 19.140625 C 16.878312 19.212625 16.967844 19.248047 17.089844 19.248047 C 17.253844 19.248047 17.366734 19.183641 17.427734 19.056641 C 17.488734 18.929641 17.522344 18.718875 17.527344 18.421875 L 18.474609 18.476562 C 18.479609 18.518563 18.482422 18.578344 18.482422 18.652344 C 18.482422 19.103344 18.358328 19.440109 18.111328 19.662109 C 17.864328 19.885109 17.517406 19.996094 17.066406 19.996094 C 16.525406 19.996094 16.145734 19.825328 15.927734 19.486328 C 15.709734 19.147328 15.601562 18.623109 15.601562 17.912109 L 15.601562 17.060547 C 15.601562 16.328547 15.714453 15.794031 15.939453 15.457031 C 16.164453 15.120031 16.551656 14.951172 17.097656 14.951172 z M 8.4101562 15.044922 L 9.5097656 15.044922 L 9.5097656 18.625 C 9.5097656 18.842 9.5340312 18.997844 9.5820312 19.089844 C 9.6300313 19.182844 9.7083125 19.228516 9.8203125 19.228516 C 9.9153125 19.228516 10.008703 19.199625 10.095703 19.140625 C 10.183703 19.082625 10.246062 19.007969 10.289062 18.917969 L 10.289062 15.044922 L 11.388672 15.044922 L 11.388672 19.919922 L 11.386719 19.919922 L 10.527344 19.919922 L 10.433594 19.322266 L 10.408203 19.322266 C 10.174203 19.774266 9.8244219 20 9.3574219 20 C 9.0334219 20 8.7965781 19.893641 8.6425781 19.681641 C 8.4885781 19.469641 8.4101563 19.1375 8.4101562 18.6875 L 8.4101562 15.044922 z M 17.074219 15.693359 C 16.957219 15.693359 16.870453 15.728875 16.814453 15.796875 C 16.758453 15.865875 16.721125 15.978766 16.703125 16.134766 C 16.684125 16.290766 16.675781 16.527703 16.675781 16.845703 L 16.675781 17.195312 L 17.478516 17.195312 L 17.478516 16.845703 C 17.478516 16.532703 17.468266 16.296766 17.447266 16.134766 C 17.427266 15.972766 17.388031 15.858969 17.332031 15.792969 C 17.276031 15.726969 17.191219 15.693359 17.074219 15.693359 z M 13.591797 15.728516 C 13.485797 15.728516 13.388828 15.770469 13.298828 15.855469 C 13.208828 15.940469 13.144422 16.049641 13.107422 16.181641 L 13.107422 18.949219 C 13.155422 19.034219 13.217922 19.097625 13.294922 19.140625 C 13.371922 19.182625 13.453922 19.205078 13.544922 19.205078 C 13.661922 19.205078 13.753266 19.163125 13.822266 19.078125 C 13.891266 18.993125 13.941703 18.850437 13.970703 18.648438 C 13.999703 18.447437 14.013672 18.1675 14.013672 17.8125 L 14.013672 17.185547 C 14.013672 16.803547 14.002516 16.509734 13.978516 16.302734 C 13.954516 16.095734 13.911562 15.946375 13.851562 15.859375 C 13.790563 15.772375 13.703797 15.728516 13.591797 15.728516 z"/></svg>' +
            '<br/>Video ',
        className: 'fa fa-youtube',
        content:
            ` <iframe width="420" height="315"
            src="https://www.youtube.com/embed/tgbNymZ7vqY">
            </iframe> `,
    });
}

function divider(editor){
    editor.BlockManager.add('divider', {
        label: '<p style="font-size:35px;margin: 0; padding: 0;"><i class="fa fa-random"></i> </p>' +
            '<br/> Divider',
        content: '<hr style="margin: 30px 0;"/>',
    });
}
