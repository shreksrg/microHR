var _ui_tab
var _ui_dataGrid
function fixTabPanelHeight() {
    if (_ui_tab[0]) {
        _ui_tab.tabs({onSelect: function () {
            _ui_tab.find(".panel-body").css({'height': '100%'});
        }})
    }
}


function addTab(title, url) {
    if (_ui_tab.tabs('exists', title)) {
        _ui_tab.tabs('select', title);
    } else {
        var content = '<iframe scrolling="no"  frameborder="0"  src="' + url + '" style="width:100%;height:100%"></iframe>';
        $('#tt').tabs('add', {
            title: title,
            border: false,
            content: content,
            height: 1000,
            closable: true
        });
    }
}

function closeTab() {
    var tab = _ui_tab.tabs('getSelected');
    var index = _ui_tab.tabs('getTabIndex', tab);
    _ui_tab.tabs('close', index);
}

function dgReload() {
    _ui_dataGrid.datagrid('reload');
}


$(function () {
    _ui_tab = $('#tt');
    _ui_dataGrid = $('#dg');
    fixTabPanelHeight();
})
