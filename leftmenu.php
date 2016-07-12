<?php

$menuTxt = "\n\n<script langauge='javascript'>
function findPos(){
if(bw.ns4){
x = document.layers.layerMenu.pageX
y = document.layers.layerMenu.pageY
}else{ 
x=0; y=0; var el,temp
el = bw.ie4?document.all['divMenu']:document.getElementById('divMenu');
if(el.offsetParent){
temp = el
while(temp.offsetParent){ 
temp=temp.offsetParent; 
x+=temp.offsetLeft
y+=temp.offsetTop;
}
}
x+=el.offsetLeft
y+=el.offsetTop
}
return [x,y]
}



pos = findPos();

if(navigator.userAgent.indexOf(\"Firefox\")!=-1){
var versionindex=navigator.userAgent.indexOf(\"Firefox\")+8
if (parseInt(navigator.userAgent.charAt(versionindex))>=1)
	pos[0] = pos[0] - 10;
}

oCMenu=new makeCM('oCMenu')
oCMenu.pxBetween=0
oCMenu.fromLeft=pos[0];
oCMenu.fromTop=pos[1];
//oCMenu.fromLeft=129;
//oCMenu.fromTop=104;
oCMenu.rows=0
oCMenu.menuPlacement=0
oCMenu.offlineRoot='' 
oCMenu.onlineRoot='' 
oCMenu.resizeCheck=1 
oCMenu.wait=1000 
oCMenu.fillImg='cm_fill.gif'
oCMenu.zIndex=0
oCMenu.useBar=1
oCMenu.barWidth='menu'
oCMenu.barHeight='menu' 
oCMenu.barClass='clBar'
oCMenu.barX='menu'
oCMenu.barY='menu'
oCMenu.barBorderX=0
oCMenu.barBorderY=0
oCMenu.barBorderClass=''
oCMenu.level[0]=new cm_makeLevel() 
oCMenu.level[0].width=208
oCMenu.level[0].height=28 
oCMenu.level[0].regClass='clLevel0'
oCMenu.level[0].overClass='clLevel0over'
oCMenu.level[0].borderX=0
oCMenu.level[0].borderY=0
oCMenu.level[0].borderClass='clLevel0border'
oCMenu.level[0].offsetX=413
oCMenu.level[0].offsetY=0
oCMenu.level[0].rows=0
oCMenu.level[0].arrow=0
oCMenu.level[0].arrowWidth=0
oCMenu.level[0].arrowHeight=0
oCMenu.level[0].align='left'
oCMenu.level[1]=new cm_makeLevel() 
oCMenu.level[1].width=205
oCMenu.level[1].height=28
oCMenu.level[1].regClass='clLevel1'
oCMenu.level[1].overClass='clLevel1over'
oCMenu.level[1].borderX=0
oCMenu.level[1].borderY=0
oCMenu.level[1].align='left' 
oCMenu.level[1].offsetX=-200
oCMenu.level[1].offsetY=-10
oCMenu.level[1].borderClass='clLevel1border'
oCMenu.level[2]=new cm_makeLevel() 
oCMenu.level[2].width=150
oCMenu.level[2].height=20
oCMenu.level[2].offsetX=0
oCMenu.level[2].offsetY=0
oCMenu.level[2].regClass='clLevel2'
oCMenu.level[2].overClass='clLevel2over'
oCMenu.level[2].borderClass='clLevel2border'
";


$parentChildArray = $pageObject->getParentChildTree();

//echo "<pre>";
//print_r($parentChildArray);


foreach($parentChildArray as $key => $data)
{
		$menuTxt .= "oCMenu.makeMenu('top" . $key . "','','" . $pageObject->getPageNameById($key) . "','index.php?_p_=" . $key . "','');\n";

		for($amt1=0; $amt1 < count($parentChildArray[$key]); $amt1++)
		{
				$menuTxt .= "oCMenu.makeMenu('Sub" . $parentChildArray[$key][$amt1]['contentId'] . "','top" . $key . "','" . $parentChildArray[$key][$amt1]['contentName'] . "','index.php?_p_=" . $parentChildArray[$key][$amt1]['contentId'] . "','');\n";
			
		}
}

$menuTxt .= "oCMenu.construct();</script>";
?>