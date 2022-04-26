// 轉換日期格式 YYYY-MM-DD HH:mm:ss
function setDateFormat(old_Date){
    var New_Date=new Date(old_Date);
    var New_Date_format = New_Date.getFullYear() + "-" + (New_Date.getMonth() + 1 < 10 ? '0' : '') + (New_Date.getMonth() + 1) + "-" + (New_Date.getDate() < 10 ? '0' : '') + (New_Date.getDate()) + " " + (New_Date.getHours() < 10 ? '0' : '') + New_Date.getHours() + ":" + (New_Date.getMinutes() < 10 ? '0' : '') + New_Date.getMinutes() + ":" + (New_Date.getSeconds() < 10 ? '0' : '') + New_Date.getSeconds();
    return New_Date_format;
}