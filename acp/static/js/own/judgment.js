function judgment_sdk_obj(){
    var name = $('#name').val();
    var update_pack = $('#update_pack').val();
    var update_ver = $('#update_ver').val();
    var update_downurl_1 = $('#update_downurl_1').val();
    var update_memo = $('#update_memo').val();
    
    if (name == '' || name.length == 0) {
        alert('请填写要添加的APK名称');
        return false;
    }
    if (update_downurl_1 == '' || update_downurl_1.length == 0) {
        alert('请填写要添加的update_downurl_1');
        return false;
    }
    if (if_have_chinese(update_downurl_1, 'update_downurl_1')) {
        return false;
    }
    
    if (update_memo == '' || update_memo.length == 0) {
        alert('请填写要添加的update_memo');
        return false;
    }
    if (if_have_chinese(update_memo, 'update_memo')) {
        return false;
    }
    
    if (update_pack !== '' || update_pack.length !== 0) {
        if (if_have_chinese(update_pack, 'update_pack')) {
            return false;
        }
    }
    
    if(update_ver != '' || update_ver != 0){
        if (if_num(update_ver, 'update_ver')) {
            return false;
        }
    }   
    return true;
    
}



function judgment_obj() {
    var name = $('#apk_name').val();
    var pkg = $('#pkg').val();
    var apk = $('#apk').val();
    var versioncode = $('#versioncode').val();
    var size = $('#size').val();
    var md5 = $('#md5').val();

    if (name == '' || name.length == 0) {
        alert('请填写要添加的APK名称');
        return false;
    }
    if (if_have_chinese(name, 'apk_name')) {
        return false;
    }
    if (pkg == '' || pkg.length == 0) {
        alert('pkg不能为空');
        return false;
    }
    if (if_have_chinese(pkg, 'pkg')) {
        return false;
    }
    if (apk == '' || apk.length == 0) {
        alert('apk不能为空');
        return false;
    }
    if (if_have_chinese(apk, 'apk')) {
        return false;
    }
    ;
    if (versioncode == '' || versioncode.length == 0) {
        alert('versioncode版本号不能为空');
        return false;
    }
    if (if_num(versioncode, 'versioncode')) {
        return false;
    }
    if (size == '' || size.length == 0) {
        alert('包大小size不能为空');
        return false;
    }
    if (if_num(size, 'size')) {
        return false;

    }
    ;
    if (md5 == '' || md5.length == 0) {
        alert('md5不能为空');
        return false;
    }
    if (if_have_chinese(md5, 'md5')) {
        return false;
    }
    return true;
}
function if_num(obj, name) {
    var re = /^[0-9]*[1-9][0-9]*$/;
    if (!re.test(obj)) {
        alert(name + '请填写正整数int型');
        return true;
    }
    return false;
}
function if_have_chinese(obj, name) {
    var pattern = /[\u4e00-\u9fa5]/g;
    var _par = new RegExp("[~！@#￥……&*（）——|{}【】‘；：”“'。、？]");
    if (pattern.test(obj)) {
        alert(name + '不能含有中文');
        return true;
    }
    for (var i = 0; i < obj.length; i++) {
        if (_par.test(obj.substr(i, 1))) {
            alert(name + '不合法，不能包含中文字符！');
            return true;
        }
    }
    return false;
}