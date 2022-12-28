jQuery(function() {
    let btn = $('.button-apply-tree-changes');
    let tree = $('.rubrics-admin-view');
    tree.sortableLists({
        ignoreClass: 'admin-control',
        onChange(el){
            btn.prop('disabled', false);
        },
    });
    btn.on('click', (e) => {
        let data = {updateTree: true};
        data[yii.getCsrfParam()] = yii.getCsrfToken();
        data.treeData = tree.sortableListsToArray();

        $.post('', data, (ret) => {
            if (ret.ok) {
                btn.prop('disabled', true);
            }
        });
    });

});