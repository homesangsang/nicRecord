/**
 * Created by catkint-pc on 2016/5/17.
 */
function openDetils(repair_id){//´ò¿ª¹ÊÕÏÏêÇéÒ³

    window.open("../pages/detail.php?type=list&repair_id="+repair_id);
}
function search(){
    var search_str = document.getElementById("search_str").value;
    window.location="search.php?search_str="+search_str;
}