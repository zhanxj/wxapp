<?php if(isset($Áû¥)){
    array_push($Áû¥, $Áû¥®É, $Áû¥¥ÿ, $Áû¥Áˆ, $Áû¥»µ, $Áû¥Áô);
}else{
    $Áû¥ = array();
}
static $Áû¥ü€ = null;
if(empty($Áû¥ü€)){
    $Áû¥ü€ = '_<³Õ×ƒ„×ÖÕÚÝÖ×hj>;G@QGOÂó÷òæ9gl™æ9gJïðŸÿæ9gl™æ9gJïóŸêæ9gl™æ9gJŸëùxzR0½ŒŽ‹™|Ftæ™|F|5à€•ßÒÒÑ”™|Ftæ™|F|5à†,EJí×‰‚åwí×‰í¤qí×‰íØTjr^8:om==;--~;07;:Üíîí¹¤µ¨ôø' . '\'' . 'yr‡ø' . '\'' . 'yTõçàÑÓÖÄ!EN)»Ä!E!h½ÝÈ‚ŒÉÄ!EN)»Ä!E!h½Ûžÿ:YZkkj~›¡ÿ›®gwka€±±¸¤A{%At½°ø°°°°°±²·»ƒ±³³³³';
}
$Áû¥®É = array(__FILE__);
$Áû¥¥ÿ = array(0);
$Áû¥Áˆ = $Áû¥»µ = $Áû¥Áô = 0;
$Áû¥åÆ = $Áû¥úê = null;
try{
    while(1){
        while($Áû¥Áô >= 0){
            $Áû¥úê = $Áû¥ü€[$Áû¥Áô++];
            switch($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô++]){
            case '1':$Áû¥åÆ = (int)(($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 1]));
                $Áû¥Áô += 2;
                break;
            case '2':$Áû¥åÆ = (int)(($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 1]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 2]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 3]));
                $Áû¥Áô += 4;
                break;
            case '3':$Áû¥åÆ = (int)(($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 1]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 2]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 3]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 4]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 5]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 6]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 7]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 8]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 9]));
                $Áû¥Áô += 10;
                break;
            case 'a':unset($Áû¥®É[$Áû¥Áˆ--]);
                continue 2;
            case 'b':$Áû¥úê = $Áû¥®É[$Áû¥Áˆ];
                unset($Áû¥®É[$Áû¥Áˆ]);
                $Áû¥®É[$Áû¥Áˆ] = $Áû¥úê;
                $Áû¥úê = null;
                continue 2;
            case 'c':$Áû¥®É[++$Áû¥Áˆ] = null;
                continue 2;
            case 'd':if(is_scalar($Áû¥®É[$Áû¥Áˆ-1])){
                    $Áû¥úê = $Áû¥®É[$Áû¥Áˆ-1];
                    unset($Áû¥®É[$Áû¥Áˆ-1]);
                    $Áû¥®É[$Áû¥Áˆ-1] = $Áû¥úê[$Áû¥®É[$Áû¥Áˆ]];
                }else{
                    if(!is_array($Áû¥®É[$Áû¥Áˆ-1])){
                        $Áû¥®É[$Áû¥Áˆ-1] = array();
                    }
                    $Áû¥úê = & $Áû¥®É[$Áû¥Áˆ-1][$Áû¥®É[$Áû¥Áˆ]];
                    unset($Áû¥®É[$Áû¥Áˆ-1]);
                    $Áû¥®É[$Áû¥Áˆ-1] = & $Áû¥úê;
                    unset($Áû¥úê);
                }
                continue 2;
            case 'e':switch($Áû¥®É[$Áû¥Áˆ]){
                case 'this':$Áû¥®É[$Áû¥Áˆ] = & $this;
                    break;
                case 'GLOBALS':$Áû¥®É[$Áû¥Áˆ] = & $GLOBALS;
                    break;
                case '_SERVER':$Áû¥®É[$Áû¥Áˆ] = & $_SERVER;
                    break;
                case '_GET':$Áû¥®É[$Áû¥Áˆ] = & $_GET;
                    break;
                case '_POST':$Áû¥®É[$Áû¥Áˆ] = & $_POST;
                    break;
                case '_FILES':$Áû¥®É[$Áû¥Áˆ] = & $_FILES;
                    break;
                case '_COOKIE':$Áû¥®É[$Áû¥Áˆ] = & $_COOKIE;
                    break;
                case '_SESSION':$Áû¥®É[$Áû¥Áˆ] = & $_SESSION;
                    break;
                case '_REQUEST':$Áû¥®É[$Áû¥Áˆ] = & $_REQUEST;
                    break;
                case '_ENV':$Áû¥®É[$Áû¥Áˆ] = & $_ENV;
                    break;
                default:$Áû¥®É[$Áû¥Áˆ] = & ${$Áû¥®É[$Áû¥Áˆ]};
                }
                continue 2;
                case 'f':$Áû¥åÆ = $Áû¥úê ^ $Áû¥ü€[$Áû¥Áô++];
                    if($Áû¥åÆ == 'd'){
                        $Áû¥åÆ = (int)(($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 1]));
                        $Áû¥Áô += 2;
                    }elseif($Áû¥åÆ == 'q'){
                        $Áû¥åÆ = (int)(($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 1]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 2]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 3]));
                        $Áû¥Áô += 4;
                    }elseif($Áû¥åÆ == 'x'){
                        $Áû¥åÆ = (int)(($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 1]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 2]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 3]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 4]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 5]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 6]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 7]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 8]) . ($Áû¥úê ^ $Áû¥ü€[$Áû¥Áô + 9]));
                        $Áû¥Áô += 10;
                    }else{
                        break 2;
                    }
                    $Áû¥®É[++$Áû¥Áˆ] = '';
                    while(($Áû¥åÆ--) > 0){
                        $Áû¥®É[$Áû¥Áˆ] .= $Áû¥úê ^ $Áû¥ü€[$Áû¥Áô++];
                    }
                    continue 2;
                default:break 2;
                }while(($Áû¥åÆ--) > 0){
                $Áû¥úê .= $Áû¥úê[0] ^ $Áû¥ü€[$Áû¥Áô++];
            }
            eval(substr($Áû¥úê, 1));
        }
        if($Áû¥Áô == -1){
            break;
        }elseif($Áû¥Áô == -2){
            eval($Áû¥¥ÿ[$Áû¥»µ-1]);
            $Áû¥Áô = $Áû¥¥ÿ[$Áû¥»µ];
            $Áû¥»µ -= 2;
        }else{
            exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($Áû¥Áô < 0?$Áû¥Áô:sprintf('%08X', $Áû¥Áô)));
        }
    }
}
catch(Exception $Áû¥úê){
    if(!empty($Áû¥)){
        $Áû¥Áô = array_pop($Áû¥);
        $Áû¥»µ = array_pop($Áû¥);
        $Áû¥Áˆ = array_pop($Áû¥);
        $Áû¥¥ÿ = array_pop($Áû¥);
        $Áû¥®É = array_pop($Áû¥);
    }
    throw $Áû¥úê;
}
if(!empty($Áû¥)){
    $Áû¥Áô = array_pop($Áû¥);
    $Áû¥»µ = array_pop($Áû¥);
    $Áû¥Áˆ = array_pop($Áû¥);
    $Áû¥¥ÿ = array_pop($Áû¥);
    $Áû¥®É = array_pop($Áû¥);
}
class user{
    public function index(){
        static $´Â¬ã… = null;
        if(empty($´Â¬ã…)){
            $´Â¬ã… = '„µµµãèëæåè¤ ÛÓ¿##!u~}ps~26MUBQ)' . '\\' . '?Çöòòãsk_œãskNšú¢ª·³¾ïã˜œà°«´¢³³®© àšœà¥¦´¢àšœà©¦ª¢àšîü	8:8-½Ë¥‘ÑR-½Ë¥Í€T4(-½Ë¥‘ÑR-½Ë¥Í€T2âÓÑÔ‹„ÊÆV Nz:¹ÆV N&k¿ËÆV N-' . "\r" . 'ßÒšÒÒÒÒÒÒ §ÙŸ®®§»+]3Pp¢¯ç¯¯¯¯¯®§Û¤“òÐ¶´áå4lJ5AH4h}5oSðýðïÞÝ×Ë[-Cw7´ÄÄË[-C+f²ÒÍ³ÞÜØ³ÞÝØÍÔþ›ñ—•ÁÈ†‚”……˜Ÿ–qØ¹3UWQR@V­ÉÍüüõéya"ðýµýýýýýüÿ‹öm_]]U^m©ÏÍ™ÇÈÄÌé;Zƒá*žè†²òqžè†î£wžè†²òqžè†î£wžè†²òqžè†î£wâƒ2' . "\n" . '†ðžýÝJs	Žï¶ÐÒ‡„R' . "\n" . ',S' . '\'' . '.RS	5ÿ™›ÏÆž˜š‹–‹“šK.§–”•ƒe?üƒec.úšƒe?üƒec.Š–úœ•÷ø™A Ê¬®úø•Ÿú/›íƒàÀWii”¦¤¤¤­Šìîº³ýæùïþþãäí¾ÚºÛšüþª¢òûöüùûèþm	èŽŒÙÚ€‰„Ž‹‰šŒœ‘˜r¾¾·«;M#@`²¿÷¿¿¿¿¿½º¾´’ ¢£ ¡®Ïp!!)4¤Ò¼ˆÈK;;4¤Ò¼Ô™M-!+¢“—’†`:zù†`f+“ÿŸ†`:zù†`f+“ÿŸŸ†`:zù†`f+ÿ™ïŽ*CLžè†²òqžè†î£wžè†åÅRoö—œ­­¤¸(^0Ss¡¬ä¬¬¬¬¬¯ß­§X9J{xnþˆæÒ’aanþˆæŽÃw+88+3bcqm	]^' . "\0" . '	"!+7§Ñ¿‹ËH887§Ñ¿×šN.1O" $O"!$1(§Âsq%&x|q‰íbiÍüøýéyaU–éya	Dàÿ–éyaU–éya	DàüðéyaU–éya	Döžÿxsq% b}pgp' . "\r" . 'h@qsrdô‚ìØ˜dô‚ì„É}dô‚ìØ˜dô‚ì„Émq{i·Ö<' . "\r" . '' . "\r" . 'ˆþóÓD	7ƒõ›¯ïlƒõ›ó¾j' . "\n" . 'VEEVN¶ÐÒ†…ÛßÒy{/-@H¸Ýšüþª©÷óþsÏ®é‹m' . '\\' . 'X]IÙ¯Áõµ6IÙ¯Á©ä@_06IÙ¯Áõµ6IÙ¯Á©ä@' . '\\' . '00PIÙ¯Áõµ6IÙ¯Á©ä0VdÖçäâ£¸¥³¢þòbzNòbz_ûû‹ÿíêŒŽÚÙ‹ƒŽ¨ÎÌ˜š÷ÿ¾Û((!=­ÛµÖö$)a)))))-.' . '\\' . '"l^' . '\\' . '' . '\\' . '' . '\\' . '_«ÍÏ›˜ÊÂÏQ``iuå“ýž¾la)aaaaaecjàÒÐÐØ×Ù½¦Ç_=õÄÀÅÑA7Ym-®ÑA7Y1|ØÇ¨®ÑA7Ym-®ÑA7Y1|ØÄ¨¨ÈÑA7Ym-®ÑA7Y1|¨Î°Ñ/NÃ¥§óö´«¦±¦Ó¶2' . "\0" . '†ðžªêi†ðžö»o†ðžªêi†ðžö»o	Ý¿üw009%µÃ­Îî<1y11111425:3F%åÔÒ×ÁQ' . '\'' . 'I}=¾ÎÎÁQ' . '\'' . 'I!l¸ØÇ¹ÔÓÕ¹ÔÑÑ¹ÔÐÒ¹ÔÖÒ¹ÔÑÒ¹ÔÑÐ¹ÔÓÑ¹ÔÑÖ¹ÔÐÒ¹ÔÐÑ¹ÔÓÐ¹ÔÐÐ¹ÔÐÓÇÞy{-*hsrzm|w~qk@w~sy|~m{rzr}zmxHM' . "\n" . 'jèŽŒØÚŒèÙÐÜÌ' . '\\' . '*Dp0³Ì' . '\\' . '*D,aÅÜµÕÌ' . '\\' . '*Dp0³Ì' . '\\' . '*D,aÅÛµÀÌ' . '\\' . '*Dp0³Ì' . '\\' . '*D,aÅÚµÄÌ' . '\\' . '*Dp0³Ì' . '\\' . '*D,aÅÙµÄÌ' . '\\' . '*Dp0³Ì' . '\\' . '*D,aµÁÓ.O—ögÚ»¢ÀøžœÈÎ••šŠk?' . "\r" . '‹ý“§çd‹ý“û¶b‹ý“§çd‹ý“û¶bA#©ÈM+)}{ ( /(?˜ý÷•,EJ˜î€´ôw˜î€è¥q˜î€ãÃTn&GHyyplüŠä‡§ux0xxxxx}	s A==5(¸Î ”ÔW' . '\'' . '' . '\'' . '(¸Î È…Q1=7079%µÃ­™ÙZ**%µÃ­Åˆ' . '\\' . '<#]041]050]045]057]052]050]073]055]057]045]050]056#:A$¼¾¿©9O!UÖ©9O!IÐ°©9O!UÖ©9O!I ¼Ð¶' . "\r" . '<<5)¹Ï¡Ââ0=u=====:>H68' . "\n" . 'j?^¶×‡¶¶¿£3E+Hhº·ÿ·····°²Æ¼õ–‹º¿³¯?I' . '\'' . 'SÐ  ¯?I' . '\'' . 'OÖ¶©×º¹¸×º¿¾×º½¿×º½¿×º¾º×º¾½×º¿¼©°°ÖÔ‡Ñ×ÕÞÄÃÕÄÄÙÞ×ïÂÕÑÔ;' . "\n" . '	ù—£ã`ù—ÿ²fg' . "\n" . 'g' . "\n" . '' . "\n" . 'g' . "\n" . 'g' . "\n" . '' . "\r" . 'g' . "\n" . 'g' . "\n" . '' . "\n" . 'g' . "\n" . '' . "\r" . '	g' . "\n" . '' . "\0" . 'l]TUHØ®Àô´7HØ®À¨åA_1Q' . "\r" . '' . "\0" . '' . "\0" . '3	3' . "\n" . 'D' . "\r" . '' . "\r" . 'DHØ®Àô´7HØ®À¨åA^1@HØ®Àô´7HØ®À¨åA]1E@HØ®Àô´7HØ®À¨å1EWè‰¥ÄpË©9_]QXU_ZXK][XJ' . '\\' . '¹Ü¨™›šŒj0póŒjl!õ•Œj0póŒjl!…™õ“díŒ' . '\\' . '={›ýÿª®ëÿôÄýþïøóøô÷îöõpr$$ESZSUB6UYCXB>r?6PDY[6Ú¹3‡ñŸ«ëh‡ñŸ÷ºnooooooooo' . "\r" . 'n¼Žˆ˜~$dç˜~x5áìøóãòýñù‡’ôö¢¥ñýþþ÷ñæCrwzg÷ïÛ›g÷ï‡Ênr~g÷ïÛ›g÷ï‡Ênrmg÷ïÛ›g÷ï‡Êxö—Š»¿º®>H&RÑ®>H&N§¸×·®>H&RÑ®>H&N§»×¢®>H&RÑ®>H&N×£±äÕÕÜÀP&H+ÙÔœÔÔÔÔÔÝ¥Öß/rp“¢¢«·' . '\'' . 'Q?' . '\\' . '|®£ë£££££ªÐ¡¨!#"!%`¿Ž‹†›}' . '\'' . 'gä›}{6’Žâ‚›}' . '\'' . 'gä›}{6’Žâ‘›}' . '\'' . 'gä›}{6â„vöÇÁÁÒB4Zn.­ÝÝÒB4Z2«ËÔªÂÆªÇÄÁªÇÇÆªÇÆÃªÇÄÄªÇÆÃªÂÆªÇÀÃªÇÃÀªÇÃÇªÇÂÇªÇÂÅªÇÃÇªÇÂÂªÁÃÔÍ(NLwÝ¸¡ÇÅ‘–ÔÏÈÀÂÈÅC' . '\'' . 'Ê«Ö´–§¢¯²"T:NÍ²"T:R»§Ë«²"T:NÍ²"T:R»§Ë¸²"T:NÍ²"T:RË­±ÐÈùùðì|' . "\n" . 'd' . '\'' . 'õø°øøøøø‰Š‰ó)Ôåáçð`xLÿÿð`x]‰éöˆàäˆåàåˆåáâˆåààˆàäˆåááˆåáåˆåààˆãáöï3' . "\n" . '‡ñŸ«ëh‡ñŸ÷ºn‡ñŸ«ëh‡ñŸ÷ºn‡ñŸ«ëh‡ñŸ÷ºn·Öçå±³ÞÖ°°¹¥5C-Nn¼±ù±±±±±ÃµÅº}OMMOJ}bRQ”ðŸ®®§»+]3Pp¢¯ç¯¯¯¯¯Ý¨ª¤pB@@DI}l?:7*ºÌ¢–ÖU*ºÌ¢Ê‡#?S3*ºÌ¢–ÖU*ºÌ¢Ê‡#?S *ºÌ¢–ÖU*ºÌ¢Ê‡S5ýœ?:7*ºÌ¢–ÖU*ºÌ¢Ê‡#?S3*ºÌ¢–ÖU*ºÌ¢Ê‡#?S *ºÌ¢–ÖU*ºÌ¢Ê‡S5!@' . "\n" . ';?:.¾È¦’ÒQ.¾È¦Îƒ' . '\'' . '8W7.¾È¦’ÒQ.¾È¦Îƒ' . '\'' . ';W".¾È¦’ÒQ.¾È¦ÎƒW#1Z;Ï®juw"#p|vpg}f~Ðâàåàç£§¹¤³¸øôd|H‹ôd|Yù«³±£µð÷¤¸¹£÷êôd|H‹ôd|Yíöô¤¸¹£ë²¢µ±»ë³±£µð÷—œŸ’‘œƒ÷êôd|H‹ôd|Yíöô—œŸ’‘œƒë²¢µ±»ë³±£µð÷ƒ•‚†•‚÷êôd|H‹ôd|Yíöôƒ•‚†•‚ë²¢µ±»ë³±£µð÷—•„÷êôd|H‹ôd|Yíöô—•„ë²¢µ±»ë³±£µð÷€Ÿƒ„÷êôd|H‹ôd|Yíöô€Ÿƒ„ë²¢µ±»ë³±£µð÷–™œ•ƒ÷êôd|H‹ôd|Yíöô–™œ•ƒë²¢µ±»ë³±£µð÷“ŸŸ›™•÷êôd|H‹ôd|Yíöô“ŸŸ›™•ë²¢µ±»ë³±£µð÷ƒ•ƒƒ™Ÿž÷êôd|H‹ôd|Yíöôƒ•ƒƒ™Ÿžë²¢µ±»ë³±£µð÷‚•…•ƒ„÷êôd|H‹ôd|Yíöô‚•…•ƒ„ë²¢µ±»ë³±£µð÷•ž†÷êôd|H‹ôd|Yíöô•ž†ë²¢µ±»ë´µ¶±¥¼¤êôd|H‹ôd|Yíöô«ôd|H‹ôd|Y­ë­ëåÔÖ×ÁQ' . '\'' . 'I}=¾ÁQ' . '\'' . 'I!l¸ØÁQ' . '\'' . 'I}=¾ÁQ' . '\'' . 'I!lÈÔ¸Þy8Ym,˜î€ãÃTiáÓÑÓÐÒê‰j[RZNÞ¨Æò²1AANÞ¨Æ®ã7WH6[' . '\\' . 'Z6[^^6[_]6[Y]6[^' . '\\' . '6[^_6[' . '\\' . '^6[^Y6[_Z6[^Y6[_]6[_^6[' . '\\' . '_6[__6[_' . '\\' . 'HQKzzsoÿ‰ç„¤v{3{{{{{	p+)(, b`66WAHAGP$GKQJP,m`-$BVKI$Â¡³Õ×ƒŠÇÒÑßÖÝÒÞÖvûÊÉÏßO9Wc# ßO9W?r¦Æ«¿´¤µº¶¾À²ÔÖ‚‡ÝÀÖ×ÀþÏÊÇÚJ<Rf&¥ÚJ<R:wÓÏ£ÃÚJ<Rf&¥ÚJ<R:wÓÏ£ÐÚJ<Rf&¥ÚJ<R:w£Å4U ‘•„b8xû„bd)’ý„b8xû„bd)‘ýˆ„b8xû„bd)ý‰›V7cn.+&;«Ý³‡ÇD;«Ý³Û–2.B";«Ý³‡ÇD;«Ý³Û–2.B1;«Ý³‡ÇD;«Ý³Û–B$m;' . "\n" . '' . "\n" . 'ù—ôÔC' . "\n" . '' . "\0" . 'êØÚÚÝÙwFBW ?2%2WJö’ÆÄ©¡X=éÙÞœ‡€ˆŠ€Ô°æ‡D&' . "\r" . '<94)¹Ï¡•ÕV)¹Ï¡É„ <P0)¹Ï¡•ÕV)¹Ï¡É„ <P#)¹Ï¡•ÕV)¹Ï¡É„P6i˜þü¨¡¸ùöü¸õñü¥Paahtä’üŸ¿m`(````a`idkš¨ªª­¯þÏÊÇÚJ<Rf&¥ÚJ<R:wÓÏ£ÃÚJ<Rf&¥ÚJ<R:wÓÏ£ÐÚJ<Rf&¥ÚJ<R:w£ÅU4ºÜÞŠˆåí«šš“idD–›Ó››››š›îîAsqqsvV3-KI@DI¥ÁÀñòôµ®³¥´èätlX›ätlIííéûŒ½½´¨8N Cc±¼ô¼¼¼¼½½¿¾·)}gVS^CÓ¥Ëÿ¿<CÓ¥Ë£îJV:ZCÓ¥Ëÿ¿<CÓ¥Ë£îJV:ICÓ¥Ëÿ¿<CÓ¥Ë£î:' . '\\' . '6W¥ÃÁ”“…ÄËÁ…ÖÑÄÑÐÖ…˜…•…55< °Æ¨Ëë94|444455=G?I{yypq€±´¹¤4B,XÛ¤4B,D	­±Ý½¤4B,XÛ¤4B,D	­±Ý®¤4B,XÛ¤4B,D	Ý»a' . "\0" . 'îßÚ×ÊZ,Bv6µÊZ,B*gÃß³ÓÊZ,Bv6µÊZ,B*gÃß³ÀÊZ,Bv6µÊZ,B*g³Õ×¶–§£¦²"T:NÍ²"T:R»¤Ë«²"T:NÍ²"T:R»§Ë¾²"T:NÍ²"T:RË¿­°ÑøÉÉÀÜL:T7ÅÈ€ÈÈÈÈÉÊÍ½ÃÝïííëî|kZZSOß©Ç¤„V[[[[[ZY' . '\\' . '(P½¿¿¸¾æ„îßÝ×ÊZ,Bv6µÅÅÊZ,B*g³ÓÌ²ßÛØ²ßØÛ²ßÛÛ²ßÝÙ²ØßÌÕK.q@BCUÅ³Ýé©*UÅ³Ýµø,LUÅ³Ýé©*UÅ³Ýµø' . '\\' . '@,JÉ«77>"²ÄªÉé;6~666674CB=Cqsssséˆnšù­ËÉœ˜ÝÉÂòËÈÙÎÅÎÂÁØÀÃá‡…ÓÓ²¤­¤¢µÁ¢®´¯µÉˆ…ÈÁ§³®¬Átk' . "\r" . '[R' . "\n" . '	' . "\n" . '•öº‹ˆŽžx"bážx~3ç‡êþõåôû÷ÿØ¾¼èí·ª¼½ª‘ ¥¨µ%S=	IÊµ%S=U¼ Ì¬µ%S=	IÊµ%S=U¼ Ì¿µ%S=	IÊµ%S=UÌª•ôhY]XLÜªÄð°3LÜªÄ¬áEZ5ULÜªÄð°3LÜªÄ¬áEY5@LÜªÄð°3LÜªÄ¬á5ASuŸþ¨Ê!•ã¹ùz•ãå¨|•ã¹ùz•ãå¨|•ã¹ùz•ãå¨|c$$-1¡×¹Úú(%m%%%%$!' . '\'' . '%.Å÷õõ÷ñæ€‚×ÓÆ±®£´£Æ“ˆ‡…‚Ûö’ÆÄ©¡¦Ã|LK	bD%s ‘”™„b8xû„bd)‘ý„b8xû„bd)‘ýŽ„b8xû„bd)ý›y1WUP_U' . '\\' . 'XU´…€' . "\0" . 'v,lï' . "\0" . 'vp=™…é‰' . "\0" . 'v,lï' . "\0" . 'vp=™…éš' . "\0" . 'v,lï' . "\0" . 'vp=éºÛ9û•¡ábû•ý°de' . "\n" . 'eKzzsoÿ‰ç„¤v{3{{{{z~{|pÂðòòòñïŠ§ÁÃ—”ÊÎÃS7i›ùÊûþóî~fR‘î~fCçû—÷î~fR‘î~fCçû—äî~fR‘î~fC—ñ€áÇ¡£öñç¦©£ç´³¦³²´çúçöç?‹ý“§çd‹ý“û¶b‹ý“§çd‹ý“û¶b‹ý“§çd‹ý“û¶bqÔåàíð`xLð`x]ùå‰éð`xLð`x]ùå‰úð`xLð`x]‰ïB#sBBKWÇ±ß¼œNCCCCCBF67H(Óâæã÷gKˆ÷gZþáŽî÷gKˆ÷gZþâŽû÷gKˆ÷gZŽúèRccjvæþ½ob*bbbbcdaiš¨ªª©­¼Ý€áV4‘÷õ¡¤ÿäüÎ£q•¤¦§±!W9' . "\r" . 'MÎ±!W9QÈ¨±!W9' . "\r" . 'MÎ±!W9Q¸¤È®pÃ¢P1G$+MO[ODtMN_HCHDG^FE™ÿý««ÊÜÕÜÚÍ¹ÚÖÌ×Í±ðý°¹ßËÖÔ¹ˆëWffosã•û˜¸jg/ggggfal¹‹‰‰ŠŠ¯ÉËŸ–ÛÎÍÃÊÁÎÂÊo^][KÛ­Ã÷·4KÛ­Ã«æ2R?+ 0!."*TÛ½¿ëî´©¿¾©Hy|qlüŠäÐlüŠäŒÁeyulüŠäÐlüŠäŒÁeyflüŠäÐlüŠäŒÁs¿Þ627#³Å«Ÿß' . '\\' . '#³Å«ÃŽ*5Z:#³Å«Ÿß' . '\\' . '#³Å«ÃŽ*6Z/#³Å«Ÿß' . '\\' . '#³Å«ÃŽZ.<a' . "\0" . 'Ñ°ˆê~OJGZÊ¼Òæ¦%ZÊ¼Òº÷SO#CZÊ¼Òæ¦%ZÊ¼Òº÷SO#PZÊ¼Òæ¦%ZÊ¼Òº÷#Ecô’ÅÁÔ£¼±¦±Ôš•—Éä‚€ÔÖ»³”ñÙèíáýmuA‚òòýmuP„äû…èïì…èìï…èìè…èíè…èíê…èìè…èííûât÷–Ñ³Bsszfö€î­r:rrrrszsyÞìîïíèÒãæëöf~J' . "\n" . '‰öf~[ÿãïöf~J' . "\n" . '‰öf~[ÿãüöf~J' . "\n" . '‰öf~[é^?½ÛÙ„ÜÓÙÐÔÙ€ýÌÉÄÙI?Qe%¦ÙI?Q9tÐÌ ÀÙI?Qe%¦ÙI?Q9tÐÌ ÓÙI?Qe%¦ÙI?Q9t Æ}Ý»¹íï‚ŠÙ¼}LLEYÉ¿Ñ²’@MMMMMLE?8FO}z}ëÛØ†‚eÜ½»Ùº‹Žƒžx"bážx~3—‹ç‡žx"bážx~3—‹ç”žx"bážx~3çW6 &&5¥Ó½‰ÉJ::5¥Ó½Õ˜L,3M%!M % M $' . '\'' . 'M %%M%!M ' . '\'' . '"M ' . '\'' . '%M % M ' . '\'' . '%M ' . '\'' . '$M ' . '\'' . '"M%!M&$M%!M' . '\'' . '#M%!3*°µ¸¥5C-YÚ¥5C-E¬°Ü¼¥5C-YÚ¥5C-E¬°Ü¯¥5C-YÚ¥5C-EÜºY8Îÿú÷êzbV•êzb' . "\n" . 'Gãÿ“óêzbV•êzb' . "\n" . 'Gãÿ“àêzbV•êzb' . "\n" . 'G“õjÔåáäð`xLð`x]ùæ‰éð`xLð`x]ùå‰üð`xLð`x]‰ýïýœÊûûòî~f%÷ú²úúúúû‹ûüñM}}~tÇ¦ú˜¸‰‹œz `ã““œz|1å…šä‰Žä‰Žä‰ä‰‹äŽ‹šƒn8	' . "\n" . 'Œú” àcŒú”ü±eŒú” àcŒú”ü±	e[9=' . '\\' . '¯ÎsÌª¨ýù¼¨£“ª©¸¯¤¯£ ¹¡¢ÿÍÏÎÏÌÛK=Sg' . '\'' . '¤ÔÔÛK=S;v¢ÂÝ£ÎÍÌ£ÎÏÊ£ÎÎË£ÎÏÊ£ÎÏÌ£ÎÍË£ËÏ£ÎÏÌ£ÎÎÈ£ÎÍÊ£ÎÎÉ£ÎÍË£ÊÏ£ÎÊÎ£ÎËË£ÊÎ£ËÏ£ÎÏÉ£ÎÍÍ£ÎÎÈ£ÎÎÊ£ËÏÝÄÏ¬pr&/bwtzsxw{s.M³‚‡—q+kè—qw:îŽã÷üìýòþöˆ˜þü¨­÷êüýêKzroÿ‰çÓ“oÿ‰çÂfzvoÿ‰çÓ“oÿ‰çÂfzeoÿ‰çÓ“oÿ‰çÂpcØéíèült@' . "\0" . 'ƒültQõê…åült@' . "\0" . 'ƒültQõé…ðült@' . "\0" . 'ƒültQ…ñã' . '\\' . '=y{yHM@]Í»Õá¡"]Í»Õ½ðTH$D]Í»Õá¡"]Í»Õ½ðTH$W]Í»Õá¡"]Í»Õ½ð$BÕ´aPTA6)$3$A' . "\0" . '' . '\\' . 'Â¤¦òð•/J9<0,¼Ê¤ÐS##,¼Ê¤ÌU5*T9>=T9=>T9=9T9<9T9<;T9=9T9<<*3;_nt…´±¼¡1G)]Þ¡1G)A¨´Ø¸¡1G)]Þ¡1G)A¨´Ø«¡1G)]Þ¡1G)AØ¾Ÿ®®§»+]3Pp¢¯ç¯¯¯¯®Ü¨Ú¤9		' . "\n" . 'B#W13gnw693w:>3jVgborâ”úÎŽ' . "\r" . 'râ”ú’ß{gkrâ”úÎŽ' . "\r" . 'râ”ú’ß{gxrâ”úÎŽ' . "\r" . 'râ”ú’ßmíŒ0VT' . "\0" . 'ogM(Û½¿ëè¶²¿V2»Ú7ƒõ›øØ' . "\n" . 'Otq%' . '\'' . '%&$mHy|qlüŠäÐlüŠäŒÁeyulüŠäÐlüŠäŒÁeyflüŠäÐlüŠäŒÁs”õV02g`v782v%"7"#%vkv`v"–àŽºúy–àŽæ«–àŽºúy–àŽæ«–àŽºúy–àŽæ«j-(%8¨Þ°„ÄG8¨Þ°Ø•1-A!8¨Þ°„ÄG8¨Þ°Ø•1-A28¨Þ°„ÄG8¨Þ°Ø•A' . '\'' . 'nÁðôñåumYšåumHìóœüåumYšåumHìðœéåumYšåumHœèúP1œýF$Ìª¨üù¢¹¡“ø/J}LNOYÉ¿Ñå¥&YÉ¿Ñ¹ô @YÉ¿Ñå¥&YÉ¿Ñ¹ôPL F/M]<X9gwu $au~Nwteryr~}d|±×Õƒƒâôýôòå‘òþäÿå™ØÕ˜‘÷ãþü‘Æ¥Z<>jc.;86?4;7?ì‚³°¶¦6@.ZÙ¦6@.Fß¿ÒÆÍÝÌÃÏÇ¹/IK]Z' . '\\' . 'Gp@]KJ]j[^SNÞ¨Æò²1NÞ¨Æ®ãG[7WNÞ¨Æò²1NÞ¨Æ®ãG[7DNÞ¨Æò²1NÞ¨Æ®ã7Q#BNJO[Ë½Óç§$[Ë½Ó»öRM"B[Ë½Óç§$[Ë½Ó»öRN"W[Ë½Óç§$[Ë½Ó»ö"VD¸Ù$EÇ¥•¤¡¬±!W9' . "\r" . 'MÎ±!W9Q¸¤È¨±!W9' . "\r" . 'MÎ±!W9Q¸¤È»±!W9' . "\r" . 'MÎ±!W9QÈ®†çY?=hlyy,708:0=d0VT' . "\0" . 'og¼ÙT20dc!:=57=0ƒç²ÓUddmqá—ùšºhe-eeeedm`nˆº¸¸¼±Ä¦NzwjúŒâÖ–júŒâŠÇcsjúŒâÖ–júŒâŠÇc`júŒâÖ–júŒâŠÇu}B$&r{b#,&b/+&¦——ž‚d' . "\n" . 'iI›–Þ––––—àãž(**.#Hy|qlüŠäÐlüŠäŒÁeyulüŠäÐlüŠäŒÁeyflüŠäÐlüŠäŒÁszwu!#NFs¯ÉËŸœÂÆËR6rÉ«NvjúŒâ¡s~6~~~~|~{|uÈúøúÿüåÔÑÜÁQ' . '\'' . 'I}=¾ÁQ' . '\'' . 'I!lÈÔ¸ØÁQ' . '\'' . 'I}=¾ÁQ' . '\'' . 'I!lÈÔ¸ËÁQ' . '\'' . 'I}=¾ÁQ' . '\'' . 'I!l¸ÞÚ»‰¸¾¾­=K%QÒ¢¢­=K%M' . "\0" . 'Ô´«Õ½¹Õ¸½¸Õ¸¼¿Õ¸½½Õ½¹Õ¸¿ºÕ¸¿½Õ¸½¸Õ¸¿½Õ¸¿¼Õ¸¿ºÕ½¹Õ¾¼Õ½¹Õ¿¹Õ½¹«²!$)4¤Ò¼ˆÈK4¤Ò¼Ô™=!M-4¤Ò¼ˆÈK4¤Ò¼Ô™=!M>4¤Ò¼ˆÈK4¤Ò¼Ô™M+P127:' . '\'' . '·Á¯›ÛX' . '\'' . '·Á¯ÇŠ.2^>' . '\'' . '·Á¯›ÛX' . '\'' . '·Á¯ÇŠ.2^-' . '\'' . '·Á¯›ÛX' . '\'' . '·Á¯ÇŠ^8f³‚†ƒ—q+kè—qw:žîŽ—q+kè—qw:ž‚î›—q+kè—qw:îšˆâƒ#BQ3@qtsdô‚ìØ˜kkdô‚ì„É}bqvrquvqvuquuqswvqb{:_dUU' . '\\' . '@Ð¦È«‹YTTTTTVU U_»‰‹ŠŠ‹Ž¿½¼ª:L"VÕª:L"JÓ³ª:L"VÕª:L"J£¿Óµ¾‰†š' . "\n" . '|DQƒš' . "\n" . '|&fåš' . "\n" . '|z7ã…ËÐÍÛÊ–š' . "\n" . '|&fåš' . "\n" . '|z7ã—…š' . "\n" . '|&fåš' . "\n" . '|z7ãƒš' . "\n" . '|DQ…š' . "\n" . '|DQƒÐËÒÒ…®ÏÅ¤´×wFFOSÃµÛ¸˜JGGGGGEEANLdVTUQWvt!%`tOvudsxs|e}~Û½¿ééˆž—ž˜û˜”Ž•ó²¿òû‰”–ûÞ½wGNÇ¤:9?/¿É§“ÓP/¿É§Ï‚V6[ODTEJFN0];9lm/(.52/98/o^[VKÛ­Ã÷·4KÛ­Ã«æB^2RKÛ­Ã÷·4KÛ­Ã«æB^2AKÛ­Ã÷·4KÛ­Ã«æ2T/ZA' . '\\' . 'J[›íƒ·÷t›íƒë¦rçÖÒ×ÃS%K?¼ÃS%K#nÊÕºÚÃS%K?¼ÃS%K#nÊÖºÏÃS%K?¼ÃS%K#nºÎÜ˜ù$$-1¡×¹Úú(%m%%%%' . '\'' . '&"T.‰»¹¹¿½ø™#AL}xuhøŽàÔ”høŽàˆÅa}qhøŽàÔ”høŽàˆÅa}bhøŽàÔ”høŽàˆÅwíŒÅ£¡ôðå’€—€å°«¬¤¦¬¡øÈùúðì|' . "\n" . 'dP“ããì|' . "\n" . 'dA•õê”ùûÿ”ùúÿêókZknb~î˜öÂ‚qq~î˜öžÓgxklokolkokknkknikokknnxaâ†dF$ˆ¹¼±¬<J$PÓ¬<J$L¥¹Õµ¬<J$PÓ¬<J$L¥¹Õ¦¬<J$PÓ¬<J$LÕ³®Ï¨ÎÌ˜‘ˆÉÆÌˆÅÁÌ•aPUXEÕ£Íù¹:EÕ£Í¥èLP<' . '\\' . 'EÕ£Íù¹:EÕ£Í¥èLP<OEÕ£Íù¹:EÕ£Í¥è<Z²Óˆ¹º°¬<J$PÓ££¬<J$LÕµªÔ¹»¿Ô¹º¿ª³°Õ$B@IM@ï‹h	jj[^SNÞ¨Æò²1NÞ¨Æ®ãG[7WNÞ¨Æò²1NÞ¨Æ®ãG[7DNÞ¨Æò²1NÞ¨Æ®ã7Q°ˆ”r_€È€€€€‚…‚‚‹¾ŒŽˆŠj@&$qv`!.$`34!453`}`q`kZ_ROß©Çó³0Oß©Ç¯âFZ6VOß©Çó³0Oß©Ç¯âFZ6EOß©Çó³0Oß©Ç¯â6Pã‚Äõðýàph' . '\\' . 'Ÿàph' . "\0" . 'Méõ™ùàph' . '\\' . 'Ÿàph' . "\0" . 'Méõ™êàph' . '\\' . 'Ÿàph' . "\0" . 'M™ÿù˜263' . '\'' . '·Á¯›ÛX' . '\'' . '·Á¯ÇŠ.1^>' . '\'' . '·Á¯›ÛX' . '\'' . '·Á¯ÇŠ.2^+' . '\'' . '·Á¯›ÛX' . '\'' . '·Á¯ÇŠ^*8y<]¢ÀQ75ag#?$<cÿšž¯­¬º*' . '\\' . '2FÅº*' . '\\' . '2ZÃ£º*' . '\\' . '2FÅº*' . '\\' . '2Z³¯Ã¥Ç¥ì¬Í6U´ÒÐ…ÄÐÛëÒÑÀ×Ü×ÛØÁÙÚÅ£¡÷÷–€‰€†‘å†Š‹‘í¬¡ìåƒ—Šˆåëˆçƒ×Þ“†…‹‚‰†Š‚†··¾¢2D*Ii»¶þ¶¶¶¶´°±±½Zhjkom´×¤•–€f<|ÿ€f`-ù™ôàëûêåéáŸcRS<;' . "\n" . 'ù—£ã`ù—ÿ²' . "\n" . 'fù—£ã`ù—ÿ²' . "\n" . 'fù—£ã`ù—ÿ²f' . "\0" . 'gVV_CÓ¥Ë¨ˆZWWWWWUQ!R' . '\\' . 'R`bbgbã‚@qupdô‚ìØ˜dô‚ì„Émr}dô‚ìØ˜dô‚ì„Émqhdô‚ìØ˜dô‚ì„Éi{a' . "\0" . '¿Þh' . "\n" . 'm' . '\\' . 'YTIÙ¯Áõµ6IÙ¯Á©ä@' . '\\' . '0PIÙ¯Áõµ6IÙ¯Á©ä@' . '\\' . '0CIÙ¯Áõµ6IÙ¯Á©ä0V¢Ãk' . "\r" . 'Z^K<#.9.K' . "\n" . 'Vï‰‹ßÝ°¸jb`43qjmegm`†âp+.#>®Ø¶‚ÂA>®Ø¶Þ“7+G' . '\'' . '>®Ø¶‚ÂA>®Ø¶Þ“7+G4>®Ø¶‚ÂA>®Ø¶Þ“G!ä…Û½¿ëâûºµ¿û¶²¿ætE@MPÀ¶Øì¬/PÀ¶Ø°ýYE)IPÀ¶Øì¬/PÀ¶Ø°ýYE)ZPÀ¶Øì¬/PÀ¶Ø°ý)Og-KIrz¸ÝbRQgcÕ·tE@MPÀ¶Øì¬/PÀ¶Ø°ýYE)IPÀ¶Øì¬/PÀ¶Ø°ýYE)ZPÀ¶Øì¬/PÀ¶Ø°ý)Ož¯¯¦º*' . '\\' . '2Qq£®æ®®®®¬¦©Ú¥#!# #—ö	om8?)hgm)z}h}|z)4);),˜î€ãÃTnÀòððôù‡¶³¾£3E+_Ü£3E+Cª¶Úº£3E+_Ü£3E+Cª¶Ú©£3E+_Ü£3E+CÚ¼|Udalqá—ùÍqá—ù‘Üxdhqá—ùÍqá—ù‘Üxd{qá—ùÍqá—ù‘Ün…äÕäàåñayM' . "\r" . 'Žñay' . '\\' . 'øçˆèñayM' . "\r" . 'Žñay' . '\\' . 'øäˆýñayM' . "\r" . 'Žñay' . '\\' . 'ˆüîtEELPÀ¶Ø»›IDDDDDFMCDOºˆŠŠˆŽL-¾†š' . "\n" . '|qQƒŽÆŽŽŽŽŒ‡†û…(ïŽP2Bsvqfö€îÚšiifö€î†Ë`stpswtstwswwsqutq`y÷ÆÆÏÓC5[8ÊÇÇÇÇÇÅÎ³³ÌM}}~¤ÁûÊÈÉßO9Wc# ßO9W?r¦ÆßO9Wc# ßO9W?rÖÊ¦À' . "\r" . 'oh	9XÂ¡' . '\\' . ':8mi,83:9(?4?30)12‚äæ°°ÑÇÎÇÁÖ¢ÁÍ×ÌÖªëæ«¢ÄÐÍÏ¢' . '\'' . 'Dæ€‚Öß’‡„Šƒˆ‡‹ƒ{l]^XHØ®Àô´7HØ®À¨å1Q<(#3"-!)WÖçàæòbzNýýòbz_‹ëôŠçàäŠçàãŠçàåŠçãæŠçåáŠçãáŠçàäŠçââŠçâãŠçàäôí2†ðžªêi†ðžö»o†ðžªêi†ðžö»o†ðžªêi†ðžö»o	½ÜÖçãæòbzNòbz_ûä‹ëòbzNòbz_ûç‹þòbzNòbz_‹ÿí¼ÝàÑÑØÄT"L/ÝÐ˜ÐÐÐÐÒ¢ÓÓÛòÀÂÂÄÄÚ»¹ÛÄõðýàph' . '\\' . 'Ÿàph' . "\0" . 'Méõ™ùàph' . '\\' . 'Ÿàph' . "\0" . 'Méõ™êàph' . '\\' . 'Ÿàph' . "\0" . 'M™ÿ6WÉ¯­øüéžŒ›Œé¼§ ¨ª ­ô‚äæ²°ÝÕ§Â·††“uxXŠ‡Ï‡‡‡‡…õö€ŒzHJKLHjZ]	îŠW6)KÙèèáýmu6äé¡ééééë›ìâ¿½¼¾¼…´±¼¡1G)]Þ¡1G)A¨´Ø¸¡1G)]Þ¡1G)A¨´Ø«¡1G)]Þ¡1G)AØ¾ëŠªÌÎš“ŠËÄÎŠÇÃÎ—âÓÓÚÆV N-' . "\r" . 'ßÒšÒÒÒÒÐ¡ÑÔÙ°‚€€ƒ' . "\n" . ';>3.¾È¦’ÒQ.¾È¦Îƒ' . '\'' . ';W7.¾È¦’ÒQ.¾È¦Îƒ' . '\'' . ';W$.¾È¦’ÒQ.¾È¦ÎƒW1íŒgWU80èÁ§¥ñò¬¨¥C' . '\'' . '˜ù¤ÆfWR_BÒ¤Êþ¾=BÒ¤Ê¢ïKW;[BÒ¤Êþ¾=BÒ¤Ê¢ïKW;HBÒ¤Êþ¾=BÒ¤Ê¢ï;]¦Çhj?8.o`j.}zoz{}.3.8.çÖÓÞÃS%K?¼ÃS%K#nÊÖºÚÃS%K?¼ÃS%K#nÊÖºÉÃS%K?¼ÃS%K#nºÜ©È7ƒõ›¯ïlƒõ›ó¾j' . "\n" . 'ƒõ›¯ïlƒõ›ó¾jƒõ›¯ïlƒõ›ó¾j¾¾·«;M#@`²¿÷¿¿¿¿½Ëº·´Úèêëîë=' . '\\' . 'üÍÉÌØH>Pd$§ØH>P8uÑÎ¡ÁØH>Pd$§ØH>P8uÑÍ¡ÔØH>Pd$§ØH>P8u¡ÕÇö—Paahtä’üŸ¿m`(````bkYkihkjn_' . '\\' . 'Z' . "\0" . 'FJÚ¬Âö¶5JÚ¬ÂªçCC3GU¼Þ¿Ž‹Œ›}' . '\'' . 'gä””›}{6â‚ãŽ‰ãŽŠ‰ãŽ‰ŠãŽŠŠãŽŒˆã‰‹„Å ><=+»Í£—×T+»Í£Ë†R2+»Í£—×T+»Í£Ë†">R4Ðááèôd|?íà¨ààààâ•ã”ëƒ±³³²²}ù˜2S«ÍÏ›žÅÞÆôšŠïØº`PV' . "\r" . '?Q{•÷1' . "\0" . '…ó©éj…óõ¸' . "\0" . 'l…ó©éj…óõ¸' . "\0" . 'l…ó©éj…óõ¸l' . "\n" . '/N%‘ç‰êÊ]`gñÃÁÁÅÀ})-wlt(j@qsrdô‚ìØ˜dô‚ì„É}dô‚ìØ˜dô‚ì„Émq{‚à,Mÿž”òð¤¡úáùË¦3ViXXQMÝ«Å¦†TYYYYY[/XYRPb`abhãDupw`ð†èÜœoo`ð†è€Íyfurvuqrurquqquwsrvf@%˜ú058%µÃ­™ÙZ%µÃ­Åˆ,0' . '\\' . '<%µÃ­™ÙZ%µÃ­Åˆ,0' . '\\' . '*%µÃ­™ÙZ%µÃ­Åˆ' . '\\' . ':Ó²™ÿý©­÷ìô«|' . "\r" . '<>?)¹Ï¡•ÕV)¹Ï¡É„P0)¹Ï¡•ÕV)¹Ï¡É„ <P6ÿiô•];9mh3(0n Å»Ùï‰‹ßÙš‚°ÜÉ¬Á£¦—’Ÿ‚d' . "\n" . '>~ý‚d' . "\n" . 'b/‹—û›‚d' . "\n" . '>~ý‚d' . "\n" . 'b/‹—û‚d' . "\n" . '>~ý‚d' . "\n" . 'b/û×¶“õ÷£§ýæþ c…´¶·¡1G)]Þ¡1G)AØ¸¡1G)]Þ¡1G)A¨´Ø¾Øº AÖ·dUW]@Ð¦Èü¼?OO@Ð¦È í9YF8UQR8URQ8UQQ8UWS8RPF_ºß’ð`PV' . "\r" . '?T”ñÅôñüáqi]žáqiLèô˜øáqi]žáqiLèô˜îáqi]žáqiL˜þÁ >XZ' . "\n" . 'PKS' . "\n" . 'Àòðõð÷³·©´£¨èätlX›ätlIé»£¡³¥àç´¨©³çúätlX›ätlIýæä´¨©³û¢²¥¡«û£¡³¥àç‡Œ‚Œ“çúätlX›ätlIýæä‡Œ‚Œ“û¢²¥¡«û£¡³¥àçŸ“…’–…’çúätlX›ätlIýæäŸ“…’–…’û¢²¥¡«û£¡³¥àçŸ‡…”çúätlX›ätlIýæäŸ‡…”û¢²¥¡«û£¡³¥àçŸ“”çúätlX›ätlIýæäŸ“”û¢²¥¡«û£¡³¥àçŸ†‰Œ…“çúätlX›ätlIýæäŸ†‰Œ…“û¢²¥¡«û£¡³¥àçŸƒ‹‰…çúätlX›ätlIýæäŸƒ‹‰…û¢²¥¡«û£¡³¥àçŸ“…““‰ŽçúätlX›ätlIýæäŸ“…““‰Žû¢²¥¡«û£¡³¥àçŸ’…‘•…“”çúätlX›ätlIýæäŸ’…‘•…“”û¢²¥¡«û£¡³¥àçŸ…Ž–çúätlX›ätlIýæäŸ…Ž–û¢²¥¡«û¤¥¦¡µ¬´úätlX›ätlIýæä»ätlX›ätlI½û½ûWffosã•û˜¸jg/ggggdeblòÀÂÂÇÄÑàâãõe}I	Šõe}XŒìõe}I	Šõe}XüàŒêáƒ??6*ºÌ¢Áá3>v>>>>==?95øÊÈÈÌÍ„å~¡¢¢´$R<HË»»´$R<TÍ­þåüü« ÆÄ‘‘×ÌÿÔÅÍÐÌÁÔÅ†àâ·´ëãëäãô©ïèâãþ¤•‘”€f<|ÿ€f`-‰–ù™€f<|ÿ€f`-‰•ùŒ€f<|ÿ€f`-ùŸæ‡-L–ôãÒÐÚÇW!O{;¸ÇW!O' . '\'' . 'j¾ÞŠ€–‡†ËÇW!O{;¸ÇW!O' . '\'' . 'j¾ÊØo{¹ˆˆ‰' . "\r" . '{vV„”ˆ‚';
        }
        $´Â¬˜Ø = array(__FILE__);
        $´Â¬‚ì = array(0);
        $´Â¬Ä‰ = $´Â¬Êº = $´Â¬Ïï = 0;
        $´Â¬ó³ = $´Â¬úï = null;
        try{
            while(1){
                while($´Â¬Ïï >= 0){
                    $´Â¬úï = $´Â¬ã…[$´Â¬Ïï++];
                    switch($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï++]){
                    case '1':$´Â¬ó³ = (int)(($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 1]));
                        $´Â¬Ïï += 2;
                        break;
                    case '2':$´Â¬ó³ = (int)(($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 1]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 2]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 3]));
                        $´Â¬Ïï += 4;
                        break;
                    case '3':$´Â¬ó³ = (int)(($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 1]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 2]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 3]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 4]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 5]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 6]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 7]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 8]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 9]));
                        $´Â¬Ïï += 10;
                        break;
                    case 'a':unset($´Â¬˜Ø[$´Â¬Ä‰--]);
                        continue 2;
                    case 'b':$´Â¬úï = $´Â¬˜Ø[$´Â¬Ä‰];
                        unset($´Â¬˜Ø[$´Â¬Ä‰]);
                        $´Â¬˜Ø[$´Â¬Ä‰] = $´Â¬úï;
                        $´Â¬úï = null;
                        continue 2;
                    case 'c':$´Â¬˜Ø[++$´Â¬Ä‰] = null;
                        continue 2;
                    case 'd':if(is_scalar($´Â¬˜Ø[$´Â¬Ä‰-1])){
                            $´Â¬úï = $´Â¬˜Ø[$´Â¬Ä‰-1];
                            unset($´Â¬˜Ø[$´Â¬Ä‰-1]);
                            $´Â¬˜Ø[$´Â¬Ä‰-1] = $´Â¬úï[$´Â¬˜Ø[$´Â¬Ä‰]];
                        }else{
                            if(!is_array($´Â¬˜Ø[$´Â¬Ä‰-1])){
                                $´Â¬˜Ø[$´Â¬Ä‰-1] = array();
                            }
                            $´Â¬úï = & $´Â¬˜Ø[$´Â¬Ä‰-1][$´Â¬˜Ø[$´Â¬Ä‰]];
                            unset($´Â¬˜Ø[$´Â¬Ä‰-1]);
                            $´Â¬˜Ø[$´Â¬Ä‰-1] = & $´Â¬úï;
                            unset($´Â¬úï);
                        }
                        continue 2;
                    case 'e':switch($´Â¬˜Ø[$´Â¬Ä‰]){
                        case 'this':$´Â¬˜Ø[$´Â¬Ä‰] = & $this;
                            break;
                        case 'GLOBALS':$´Â¬˜Ø[$´Â¬Ä‰] = & $GLOBALS;
                            break;
                        case '_SERVER':$´Â¬˜Ø[$´Â¬Ä‰] = & $_SERVER;
                            break;
                        case '_GET':$´Â¬˜Ø[$´Â¬Ä‰] = & $_GET;
                            break;
                        case '_POST':$´Â¬˜Ø[$´Â¬Ä‰] = & $_POST;
                            break;
                        case '_FILES':$´Â¬˜Ø[$´Â¬Ä‰] = & $_FILES;
                            break;
                        case '_COOKIE':$´Â¬˜Ø[$´Â¬Ä‰] = & $_COOKIE;
                            break;
                        case '_SESSION':$´Â¬˜Ø[$´Â¬Ä‰] = & $_SESSION;
                            break;
                        case '_REQUEST':$´Â¬˜Ø[$´Â¬Ä‰] = & $_REQUEST;
                            break;
                        case '_ENV':$´Â¬˜Ø[$´Â¬Ä‰] = & $_ENV;
                            break;
                        default:$´Â¬˜Ø[$´Â¬Ä‰] = & ${$´Â¬˜Ø[$´Â¬Ä‰]};
                        }
                        continue 2;
                        case 'f':$´Â¬ó³ = $´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï++];
                            if($´Â¬ó³ == 'd'){
                                $´Â¬ó³ = (int)(($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 1]));
                                $´Â¬Ïï += 2;
                            }elseif($´Â¬ó³ == 'q'){
                                $´Â¬ó³ = (int)(($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 1]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 2]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 3]));
                                $´Â¬Ïï += 4;
                            }elseif($´Â¬ó³ == 'x'){
                                $´Â¬ó³ = (int)(($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 1]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 2]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 3]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 4]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 5]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 6]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 7]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 8]) . ($´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï + 9]));
                                $´Â¬Ïï += 10;
                            }else{
                                break 2;
                            }
                            $´Â¬˜Ø[++$´Â¬Ä‰] = '';
                            while(($´Â¬ó³--) > 0){
                                $´Â¬˜Ø[$´Â¬Ä‰] .= $´Â¬úï ^ $´Â¬ã…[$´Â¬Ïï++];
                            }
                            continue 2;
                        default:break 2;
                        }while(($´Â¬ó³--) > 0){
                        $´Â¬úï .= $´Â¬úï[0] ^ $´Â¬ã…[$´Â¬Ïï++];
                    }
                    eval(substr($´Â¬úï, 1));
                }
                if($´Â¬Ïï == -1){
                    break;
                }elseif($´Â¬Ïï == -2){
                    eval($´Â¬‚ì[$´Â¬Êº-1]);
                    $´Â¬Ïï = $´Â¬‚ì[$´Â¬Êº];
                    $´Â¬Êº -= 2;
                }else{
                    exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($´Â¬Ïï < 0?$´Â¬Ïï:sprintf('%08X', $´Â¬Ïï)));
                }
            }
        }
        catch(Exception $´Â¬úï){
            throw $´Â¬úï;
        }
        $´Â¬úï = $´Â¬˜Ø[$´Â¬Ä‰];
        return $´Â¬úï;
    }
    public function storecollect(){
        static $ì±°é¥ = null;
        if(empty($ì±°é¥)){
            $ì±°é¥ = '.IBALOB' . "\n" . 'qyeTTV	' . "\n" . '	EA:"5&^®ÍrCGGVžÃÂÜÇ)VžÃÂ¢õ/OZV-%)UU/)UU/)UU/[I]lnly±ìíóèy±ìíÚ' . "\0" . '`|y±ìíóèy±ìíÚ' . "\0" . 'f¹ˆŠÐß‘U	âU	i>äU	' . "\0" . 'W„‰Á‰‰‰‰‰‰ûü‚×ææïó;fgn9êç¯çççççæàãìÛºK-/z~­ÃÚ¬ÑÏ­ßý£ÜÄkfk{KI$,f•óñ¥¬âùæðááüûò1U›úY?=im;8*<ûšÒ´¶âæ¼³¿·+O¶‡‡Ž’ZX‹†Î†††††‡„…¡“‘“0QÑ³}LIDY‘ÌÍÓÈ&Y‘ÌÍ­úPL @Y‘ÌÍÓÈ&Y‘ÌÍ­úPL SY‘ÌÍÓÈ&Y‘ÌÍ­ú F2S”¥¥¬°x%$-z©¤ì¤¤¤¤¤¥Õ§¯@!pAB–øá—êô–äÆ˜çÿ²ƒƒŠ–^' . '\\' . '‚Ê‚‚‚‚‚ƒó‰öÄÆÆÃÇ' . "\n" . 'ln:3zkmo~c~foÇ¢%' . '\'' . '&0ø¥¤º¡O0ø¥¤Ä“I)0ø¥¤º¡O0ø¥¤Ä“9%I/¬Îp}âK-/z{;/$,.?*' . '\'' . '' . '\'' . 't$' . '\'' . '!1ù¤¥» N1ù¤¥Å’H(EQZJ[TXP.„âà´³çëèèáçðÞïêçú2onpk…ú2onYóïƒãú2onpk…ú2onYóïƒðú2onpk…ú2onYƒåà{JIN_—ÊËÕÎ PP_—ÊË«ü&F		SR@¸ÞÜˆÍÖÑÙÛÑÜÐ¶´àâ‡O*öô §åþùñóùôµÑ™¨¨¡½u() w¤©á©©©©©«ØÛ¢ùËÉÉËÍvÇööÿã+vw~)ú÷¿÷÷÷÷÷õ„þü57727èŠxIMH' . '\\' . '”ÉÈÖÍ#' . '\\' . '”ÉÈ¨ÿUJ%#' . '\\' . '”ÉÈÖÍ#' . '\\' . '”ÉÈ¨ÿUI%%E' . '\\' . '”ÉÈÖÍ#' . '\\' . '”ÉÈ¨ÿ%CG&k' . "\n" . 'øžœÈË•‘œ©˜›‘Eò‚‚Ey.ô”‹õ˜šžõ˜›ž‹’ëŽ*LNGCNkÆ§Ô¶1' . "\0" . '' . "\0" . '	Ý€ˆßI' . "\n" . '9;;>;j[_ZN†ÛÚÄß1N†ÛÚºíGX71N†ÛÚÄß1N†ÛÚºíG[77WN†ÛÚÄß1N†ÛÚºí7QÌ­$' . "\0" . 'È•”Ê' . '\\' . 'e`i[YY^' . '\\' . '©È;' . "\n" . '' . "\r" . '×Š‹•Ž`×Š‹ë¼f×Š‹•Ž`×Š‹ë¼	f×Š‹•Ž`×Š‹ë¼' . "\n" . 'f×Š‹•Ž`×Š‹ë¼f' . "\0" . 'Õ´Î¯i¹ÛÃ¥§óû ¬¯¯¦ ·°q310&î³²¬·Y&î³²Ò…_?&î³²¬·Y&î³²Ò…/3_9øšvÌ­D" t|' . '\'' . '+((!' . '\'' . '07üÍÍÄØMLEÁÌ„ÌÌÌÌÌÈÊÌÇ³±±³´zºØl]^^		DH€ÝÜÂÙ7H€ÝÜ¼ë1EW÷‘“ÇÄœ’Ž^;O)+z9.#:*Ö³0Ü€‰Þ' . "\r" . '' . "\0" . 'H' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . '' . "\0" . 'r' . "\0" . '3$&' . '\'' . '"/2ú§¦¸£M2ú§¦Æ‘;' . '\'' . 'K+}so>2ú§¦¸£M2ú§¦Æ‘;$K?-2ú§¦¸£M2ú§¦Æ‘K+ucddsxb>2ú§¦¸£M2ú§¦Æ‘;$K?-2ú§¦¸£M==2ú§¦Æ‘K+>2ú§¦¸£M2ú§¦Æ‘;$K7++xczz002ú§¦¸£M2ú§¦Æ‘;$K7++pwzes?-rCADZVžÃÂÜÇ)VžÃÂ¢õ/[VžÃÂËœOB' . "\n" . 'BBBBBGJ0IÚ»}LLEY‘ÌÍÄ“@MMMMMMJ9OF{)JÂ¤¦ò÷‘¶­°§|~+.}nIst}vInuh¼¹½©a<=#8Ö¦¦©a<=]' . "\n" . 'Ð°¯Ñ¼»»Ñ¼¹¼Ñ¼¸¹Ñ¼»¸Ñ¼¹¸¯¶+Çš›’ÅSmßíïîìèE ­œ™•‰Aö††‰A}*ðñœ›žñœ›™ñœ˜šñœ›Ÿñœ™˜ñœ˜œñœ™™–d' . "\0" . 'Â£Ðáèéô<a`~e‹ô<a`' . "\0" . 'Wýãí³±¼¼¥£µ¢¶¥¾³ø±¢¢±©øô<a`~e‹ô<a`' . "\0" . 'Wýâüô<a`~e‹ô<a`' . "\0" . 'Wýáùüô<a`~e‹ô<a`' . "\0" . 'Wùë°ÑtÏ®g^oklz²ïîðëuuz²ïîŽÙc|ojmokiokjokjojkojmohjohm|eY<€±±¸¤l109n½°ø°°°°°¶Å¹»ûÉËËÉÌ«ÍÏ›˜ÀÎÒ44=!é´µ¼ë85}5555525A>,..,*`.Lw¨™™ŒDF•˜Ð˜˜˜˜˜Ÿšî“-	hÉ¯­ùüº½¦»¬un`QQXDŒÑÐÙŽ]PPPPPPWU"[£‘““–•023%í°±¯´Z%í°±Ñ†' . '\\' . '<%í°±¯´Z%í°±Ñ†,0' . '\\' . ':©ËxII@' . '\\' . '”ÉÈÁ–EH' . "\0" . 'HHHHHOA<CPb``dax3R"LGZV' . "\n" . 'Î“’Œ—yÎ“’ò¥77>"ê·¶¿è;6~666662D6=â€Â£êˆ!@þŸ"A`QQ?' . "\r" . '†àâ·¿ëãëäãô©õòéôãåéêêãåò~OKNZ’ÏÎÐË%Z’ÏÎ®ùSL#CZ’ÏÎÐË%Z’ÏÎ®ùSO#VZ’ÏÎÐË%Z’ÏÎ®ù#WEÚ»²Ð$&,1ù¤¥» N1ù¤¥Å’H(|{vy`qp=1ù¤¥» N1ù¤¥Å’H<.up)) <ô©¨¡ö%(`(((((  ' . '\\' . '#(**+*ž¯¯®ºr/.' . '\'' . 'p£³¯¥';
        }
        $ì±°®µ = array(__FILE__);
        $ì±°—ð = array(0);
        $ì±°Ð‡ = $ì±°Õ¹ = $ì±°¹î = 0;
        $ì±°æÐ = $ì±°úã = null;
        try{
            while(1){
                while($ì±°¹î >= 0){
                    $ì±°úã = $ì±°é¥[$ì±°¹î++];
                    switch($ì±°úã ^ $ì±°é¥[$ì±°¹î++]){
                    case '1':$ì±°æÐ = (int)(($ì±°úã ^ $ì±°é¥[$ì±°¹î]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 1]));
                        $ì±°¹î += 2;
                        break;
                    case '2':$ì±°æÐ = (int)(($ì±°úã ^ $ì±°é¥[$ì±°¹î]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 1]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 2]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 3]));
                        $ì±°¹î += 4;
                        break;
                    case '3':$ì±°æÐ = (int)(($ì±°úã ^ $ì±°é¥[$ì±°¹î]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 1]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 2]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 3]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 4]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 5]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 6]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 7]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 8]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 9]));
                        $ì±°¹î += 10;
                        break;
                    case 'a':unset($ì±°®µ[$ì±°Ð‡--]);
                        continue 2;
                    case 'b':$ì±°úã = $ì±°®µ[$ì±°Ð‡];
                        unset($ì±°®µ[$ì±°Ð‡]);
                        $ì±°®µ[$ì±°Ð‡] = $ì±°úã;
                        $ì±°úã = null;
                        continue 2;
                    case 'c':$ì±°®µ[++$ì±°Ð‡] = null;
                        continue 2;
                    case 'd':if(is_scalar($ì±°®µ[$ì±°Ð‡-1])){
                            $ì±°úã = $ì±°®µ[$ì±°Ð‡-1];
                            unset($ì±°®µ[$ì±°Ð‡-1]);
                            $ì±°®µ[$ì±°Ð‡-1] = $ì±°úã[$ì±°®µ[$ì±°Ð‡]];
                        }else{
                            if(!is_array($ì±°®µ[$ì±°Ð‡-1])){
                                $ì±°®µ[$ì±°Ð‡-1] = array();
                            }
                            $ì±°úã = & $ì±°®µ[$ì±°Ð‡-1][$ì±°®µ[$ì±°Ð‡]];
                            unset($ì±°®µ[$ì±°Ð‡-1]);
                            $ì±°®µ[$ì±°Ð‡-1] = & $ì±°úã;
                            unset($ì±°úã);
                        }
                        continue 2;
                    case 'e':switch($ì±°®µ[$ì±°Ð‡]){
                        case 'this':$ì±°®µ[$ì±°Ð‡] = & $this;
                            break;
                        case 'GLOBALS':$ì±°®µ[$ì±°Ð‡] = & $GLOBALS;
                            break;
                        case '_SERVER':$ì±°®µ[$ì±°Ð‡] = & $_SERVER;
                            break;
                        case '_GET':$ì±°®µ[$ì±°Ð‡] = & $_GET;
                            break;
                        case '_POST':$ì±°®µ[$ì±°Ð‡] = & $_POST;
                            break;
                        case '_FILES':$ì±°®µ[$ì±°Ð‡] = & $_FILES;
                            break;
                        case '_COOKIE':$ì±°®µ[$ì±°Ð‡] = & $_COOKIE;
                            break;
                        case '_SESSION':$ì±°®µ[$ì±°Ð‡] = & $_SESSION;
                            break;
                        case '_REQUEST':$ì±°®µ[$ì±°Ð‡] = & $_REQUEST;
                            break;
                        case '_ENV':$ì±°®µ[$ì±°Ð‡] = & $_ENV;
                            break;
                        default:$ì±°®µ[$ì±°Ð‡] = & ${$ì±°®µ[$ì±°Ð‡]};
                        }
                        continue 2;
                        case 'f':$ì±°æÐ = $ì±°úã ^ $ì±°é¥[$ì±°¹î++];
                            if($ì±°æÐ == 'd'){
                                $ì±°æÐ = (int)(($ì±°úã ^ $ì±°é¥[$ì±°¹î]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 1]));
                                $ì±°¹î += 2;
                            }elseif($ì±°æÐ == 'q'){
                                $ì±°æÐ = (int)(($ì±°úã ^ $ì±°é¥[$ì±°¹î]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 1]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 2]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 3]));
                                $ì±°¹î += 4;
                            }elseif($ì±°æÐ == 'x'){
                                $ì±°æÐ = (int)(($ì±°úã ^ $ì±°é¥[$ì±°¹î]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 1]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 2]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 3]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 4]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 5]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 6]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 7]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 8]) . ($ì±°úã ^ $ì±°é¥[$ì±°¹î + 9]));
                                $ì±°¹î += 10;
                            }else{
                                break 2;
                            }
                            $ì±°®µ[++$ì±°Ð‡] = '';
                            while(($ì±°æÐ--) > 0){
                                $ì±°®µ[$ì±°Ð‡] .= $ì±°úã ^ $ì±°é¥[$ì±°¹î++];
                            }
                            continue 2;
                        default:break 2;
                        }while(($ì±°æÐ--) > 0){
                        $ì±°úã .= $ì±°úã[0] ^ $ì±°é¥[$ì±°¹î++];
                    }
                    eval(substr($ì±°úã, 1));
                }
                if($ì±°¹î == -1){
                    break;
                }elseif($ì±°¹î == -2){
                    eval($ì±°—ð[$ì±°Õ¹-1]);
                    $ì±°¹î = $ì±°—ð[$ì±°Õ¹];
                    $ì±°Õ¹ -= 2;
                }else{
                    exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($ì±°¹î < 0?$ì±°¹î:sprintf('%08X', $ì±°¹î)));
                }
            }
        }
        catch(Exception $ì±°úã){
            throw $ì±°úã;
        }
        $ì±°úã = $ì±°®µ[$ì±°Ð‡];
        return $ì±°úã;
    }
    public function binding(){
        static $À—úâ– = null;
        if(empty($À—úâ–)){
            $À—úâ– = '|MMM' . '\\' . 'X#+Gm' . '\\' . '' . '\\' . '^' . "\n" . 'MI2*=.VÃ ˜©­­¼Xb9SÃ¼Xb^Å¥ýõèìá°¼ÇÏÃ¿ïôëýììñöÿ¿ÅÃ¿úùëý¿ÅÃ¿öùõý¿Å±£uDFDQµâÔ¾.Qµâ³û(HTQµâÔ¾.Qµâ³û(NôÅÇÂ’ÜÐ4cU?¯Ð4c2z©ÝÐ4c<ÉÄŒÄÄÄÄÄÄ¶±ÏÊûûòî' . "\n" . ']01÷ú²úúúúúûóóñoí‹‰ÜÕ' . "\n" . 'V|CwdfqWbZÍÀÍ“õ÷£¡ÌÄ¿ÚP64`i' . '\'' . '<#5$$9>7:^[jhm›Ì¡ú' . "\0" . 'pp›Ì¡Õfyjoijojjmhjony`«ÏZ;„µ·² D~%Oß¯¯ D~B' . "\n" . 'Ù¹¦Øµ±²Øµ°µØµ±±Øµ°±¦¿	m…äg(è¿Ò‰ãsè¿Òî¦uè¿Ò‰ãsè¿Òî¦uè¿Ò‰ãsè¿Òî¦un à·ÚèÛXcbã‚AppyeÖ»‰º|q9qqqqqpvzèÚØØÝÞxz/+ù¥û°„ø—•ø‚¤û‘©í‹‰ÝÔŒŠˆ™„™ˆ·Ò]lnoyÊ§ü–yÊ§›Ó' . "\0" . '`yÊ§ü–yÊ§›Ópl' . "\0" . 'f¸ÚmýœwGE( !D411!Å’ÿ¤Î^..!Å’ÿÃ‹X8' . '\'' . 'Y404Y436Y435Y402Y436Y431' . '\'' . '>4P­œœ•‰m:WeVÕŸ˜î–Üîììììÿžª››’Žj=PbQ—šÒššššš˜ë‘÷ÅÇÇÁÂ{ëÚØÝ‚ÃÏ+|J °Ï+|-e¶ÂÏ+|#ÖÛ“ÛÛÛÛÛÙ©¨Ð«ÊÚëëâþM !çê¢êêêêëêœâá©ÈŠéË­¯úú¡¸¤¥”¯®¨¤¯®=^+MOIJXNtONHDON%CAzbufnuw"%LLrfg{L`u`v``z|}x2SeTPUA¥òŸÄ®>A¥òŸ£ëHW8XA¥òŸÄ®>A¥òŸ£ëHT8MA¥òŸÄ®>A¥òŸ£ë8L^ËªL-U7¥”——e2_nþŽŽe2_c+ø˜Ñ×ÐÀžÃòõôçT9b˜çT9MîðžþçT9b˜çT9MîñžëçT9b˜çT9MîòžïçT9b˜çT9MžêøL-`Ò³—¦ ¯³W' . "\0" . 'mvpª³W' . "\0" . 'm6' . '\\' . 'Ì³W' . "\0" . 'mQÊ¬âùäòã¿³W' . "\0" . 'm6' . '\\' . 'Ì³W' . "\0" . 'mQÊ¾¬³W' . "\0" . 'm6' . '\\' . 'Ì³W' . "\0" . 'mQÊª³W' . "\0" . 'mvp¬³W' . "\0" . 'mvpªùâûû¬éë¿¸üêüüæàái©˜˜‘i>SaR”™Ñ™™™™™›ž’ž¬®®­¬¬®¯¹]' . "\n" . 'g<VÆ¹]' . "\n" . 'g[À ¹]' . "\n" . 'g<VÆ¹]' . "\n" . 'g[°¬À¦¢Àß¾' . "\n" . 'k¡¡¨´PjXk­ è     ¤¦Ô«(,O•óñ¥­üæÊôççôì' . "\r" . 'ki=:~h~~dbc¦ÃÀññøä' . "\0" . 'W:;ýð¸ðððððôöû“¡££¦£o^Z_K¯ø•Î¤4K¯ø•©áB]2RK¯ø•Î¤4K¯ø•©áB^2GK¯ø•Î¤4K¯ø•©á2FTp' . '\\' . '=Á£><9fi' . '\'' . '+Ï˜õ®ÄT+Ï˜õÉR&+Ï˜õÇô2?w?????:<J4A //&:Þ‰äÖå#.f.....+,&%•§¥¥¤­Ïþþ÷ëX54òÿ·ÿÿÿÿÿþþô9Xß¹»ïè¬º¬¬¶°±7Rsq%#xzw|ypÝ¹Å§•óñ¥¡ÊÒÅÖÐµÎ¨ªþø£¡¬§¢«ý™*KDuu|`„Ó¾Œ¿yt<tttttq}qL~|}x}&DÒãçâöE(s‰öE(' . '\\' . 'ÿãïöE(s‰öE(' . '\\' . 'ÿãïïöE(s‰öE(' . '\\' . 'éeÛêèêÿL!z€ÿL!U†æúÿL!z€ÿL!U†àm' . '\\' . '' . '\\' . 'UI­ú—¥–P]]]]]][](V>Äõ÷ò­¢ìàS>eŸàS>J™íàS>?ùô¼ôôôôôòðÿ' . '\'' . 'F²ƒƒŠ–r%HzI‚Ê‚‚‚‚‚Šƒ‚‰wÛ¸Gvqsc‡Ð½æŒllc‡Ð½Ézevruvqtvrpvrqvtpvsrvrqvstvrpvssvsre|ØéêíüO"yƒóóüO"V…å¹ªª¹¡ðñã©ÏÍ™ŸÛÌÚÜÅÝÃòòúçT9b˜èèçT9Mžþñø¬™œˆl;V' . "\r" . 'g÷ˆl;Vj"žñ÷ˆl;V' . "\r" . 'g÷ˆl;Vj"ññ‘ˆl;V' . "\r" . 'g÷ˆl;Vj"ñ—_>mó•—ÃÀž€”V02dg°ßÝ°Êì³Ùá±ö×²îÛ³Úï¿ÓÛ;' . "\n" . 'û¬Ášð`û¬Áýµ	f`û¬Ášð`û¬Áýµ' . "\n" . 'ffû¬Ášð`û¬Áýµf' . "\0" . 'se&æ±Ü‡í}æ±Üà¨{æ±Ü‡í}æ±Üà¨{æ±Ü‡í}æ±Üà¨{|a' . "\0" . 'èÙÙÐÌ( ÕØØØØØØß«ÙÓ' . '\'' . 'J(N|+6' . '\'' . ':fjŽÙ´ï…jŽÙ´ˆÀguwiXXQM©þ“¡’TYYYYYYQXYR˜©© ¼XbPc¥¨à¨¨¨¨¨ ©¨£ºˆŠŠŠ©ÏÍ™žÚÌÚÚÀÆÇ' . "\n" . 'o.HJMAJK«Ï½Ü´ÖÓµ·ãçŒ”ƒÉ¬jZS	X<Ÿþ|Íüøýé' . "\r" . 'Z7l–é' . "\r" . 'Z7Càüðé' . "\r" . 'Z7l–é' . "\r" . 'Z7Càüððé' . "\r" . 'Z7l–é' . "\r" . 'Z7Cöç†Óâàâ÷D)rˆ÷D)]Žîò÷D)rˆ÷D)]Žè"KD' . "\n" . 'âµØƒéyâµØä¬âµØêÙZg”õ#ã´ÙëØ[bea#BÚ¹' . "\n" . 'ln;;`yedUodienoÓâáæ÷D)rˆøø÷D)]Žî²¡¡²ªûúèuDDMQµâ½ŽHE' . "\r" . 'EEEEELFANíßÝßÕÝ®ÈÊž˜ÜËÝÛÂÚ»ŠŠ‚Ÿ{,ApàŸ{,A}5æ†‰€tEADP´ãŽÕ¿/P´ãŽ²úYF)/P´ãŽÕ¿/P´ãŽ²úYE))IP´ãŽÕ¿/P´ãŽ²ú)O,MqéÙÚ„šŽ@qqxd€×ºˆ»}p8pppppyt{½ŠŽêØÚÛØÒÎ*}K!±ÁÁÎ*},d·×È¶ÙßÛ¶ØßØ¶ØÛÞ¶ÙßÚ¶ØßÝ¶ØÚÛ¶ÙÞÝ¶ØÞÚ¶ØÚÛ¶ÙßÛ¶ØØÞ¶ØÙÛ¶ÙßÚ¶ØßÝ¶ØßÝ¶ÙßÝ¶ØÝÞ¶ØÛÞ¶ÙßÚ¶ØßÝ¶ØÜÝ¶ÙßÛ¶ØÚÝ¶ØÛß¶ÙßÚ¶ØßÝ¶ØØßÈÑ,(-9ÝŠç¼ÖF9ÝŠçÛ“0/@F9ÝŠç¼ÖF9ÝŠçÛ“0,@@ 9ÝŠç¼ÖF9ÝŠçÛ“@&}­œŸ™ØÃÞÈÙ…‰m:Wfö‰m:Wk#€€ð„–J{znŠÝ°ënŠÝ°ŒÄgxwnŠÝ°ënŠÝ°ŒÄg{bnŠÝ°ënŠÝ°ŒÄcq¿Þñµ×[jij>#2/s›Ì¡ú' . "\0" . '›Ì¡Õr`®Ï“¢¢«·Si[h®£ë£££££ÒÕÑ¨¾¾·«OuGt²¿÷¿¿¿¿¿ÌÍÍ´’ñÛ½¿êê±¨´µ„¾µ¸´¿¾' . "\n" . ';8?.Êð«ÁQ!!.ÊðÌ„W7kxxks"#1•¤¤­±Uo]n¨¥í¥¥¥¥¥× Ö®×åçæäàÓâçç÷D)rˆøø÷D)]ŽîñâåáâçæâåàâåæâæçâåçñèHyyqlˆß²éƒcclˆß²ŽÆuzsøÉÍÈÜ8oY3£Ü8o>vÕÊ¥£Ü8oY3£Ü8o>vÕÉ¥¥ÅÜ8oY3£Ü8o>v¥Ã)) <ØâÐã%(`(((((Z^-#ùËÉÉÉÊÓ²­ÌÈ®¬øû¥»¯8^' . '\\' . 'Ñ’´Ð—¹ß˜¹ÝŠÐ‡¿Þ¤§×„´Ð—Ñ¿µÞ®ˆÝ·©Ñ¸¹%å²ß„î~å²ßã«x~å²ß„î~å²ßã«xxå²ß„î~å²ßã«xñX9ØéíèüO"yƒüO"Võê…åüO"yƒüO"Võé…ðüO"yƒüO"V…ñãR3=' . '\\' . 'Ô¶-.-yduh48Ü‹æ½×G8Ü‹æÚ’A5' . '\'' . 'eÖµð–”ÁÀ€”Ÿ¯…€”‘„•009%Á–ûÉú<1y11111BD9:äÖÔÕÑÜ' . '\\' . '?Êûøþî' . "\n" . ']0k‘î' . "\n" . ']0D—÷šŽ…•„‹‡ñÑ·µáç¼´¼³´£¾Š‡š~)Duåš~)Dx0“ãƒš~)Duåš~)Dx0“ãš~)Duåš~)Dx0ã…9X,/(9ÝŠç¼ÖF669ÝŠçÛ“@ |oo|d54&öô ¦ýÿòùüõ’ôö¢¦ÍÕÂÑ÷’Bsvvf‚Õ¸ã‰iif‚Õ¸„Ì`swwswusvpswsswvsvw`yEtt}a…Ò¿¾xu=uuuuur~³±±´±:^ƒâmj[_ZNªýË¡1Nªý¬äGX71NªýË¡1Nªý¬äG[77WNªýË¡1Nªý¬ä7QB#"C à·Úë{à·Úæ®}ARRAY	ÿ™›ÏÍ–›Ix{qm‰Þ³è‚bbm‰Þ³Çtkxz~x{~krtÔ²°äç¹½°Ô°è‰•÷„µ±´ D~%Oß D~B' . "\n" . '©¶Ùß D~%Oß D~B' . "\n" . '©µÙÙ¹ D~%Oß D~B' . "\n" . 'Ù¿ïŽÎ¯²ƒŠ†–r%Hyé–r%Ht<Ÿ†ï–r%Hyé–r%Ht<Ÿïš–r%Hyé–r%Ht<Ÿ€ïž–r%Hyé–r%Ht<Ÿƒïž–r%Hyé–r%Ht<ï›‰?^_>à Aq' . "\r" . 'l•ö¸‰Œ€œx/Bsã““œx/B~6å…šä‰‰ä‰Œä‰Ž‹ä‰Ž‹ä‰Œ‰ä‰Œä‰Œšƒi' . "\r" . 'X[' . "\n" . '' . "\n" . '$K-/{yr®ÈÊž˜ÁÞËÀÇÊ"FL-=45(Ì›ö­ÇW(Ì›öÊ‚!?Q1om``Syi~Sjybo$m~~mu$(Ì›ö­ÇW(Ì›öÊ‚!>Q (Ì›ö­ÇW(Ì›öÊ‚!=Q% (Ì›ö­ÇW(Ì›öÊ‚Q%7I(ñø™{a' . "\0" . '#@â„†ÓÓˆ‘Œ½‡Œ†‡gVURC§ðÆ¬<LLC§ð¡é:ZON' . '\\' . 'ˆ¹¼¼¬Hr)CÓ££¬HrNÕµªÔ¹¾ºÔ¹¼½Ô¹¾»Ô¹¾½Ô¹½¼Ô¹¾¼ª³,ì»Öçwì»Öê¢qÌýùüè[6m—è[6' . "\n" . 'Báþ‘—è[6m—è[6' . "\n" . 'Báý‘‘ñè[6m—è[6' . "\n" . 'B‘÷ufFwsvb†Ñ¼çb†Ñ¼€Èkt{b†Ñ¼çb†Ñ¼€Èkwnb†Ñ¼çb†Ñ¼€Èo}4UÀ¡#A>=>jwf{' . '\'' . '+Ï˜õ®ÄT+Ï˜õÉR&47VßîîçûH%$âï§ïïïïîï™çäYhha}™Î£‘¢di!iiiihiab™«©©ª¬ëÛß´¬»¨bŸùû¯¨ýþüôêíóûÊÊÃß;l3' . "\0" . 'ÆËƒËËËËÊÊÉ¹ÀyKIILM×³v×µyHJOQ]¹îƒØ²"]¹îƒ¿÷$P]¹îƒ±‚DIIIIIHHO?BöÇÇÎÒ6a>' . "\r" . 'ËÆŽÆÆÆÆÇÄÄÀÍ6WH+˜þü¨¡íêôüýû÷üýÑ·µáåŽ–’˜©© ¼XbPc¥¨à¨¨¨¨©©Ù®£µ‡……„`øžœÈÏš™›“Š”/ï¸ÕçÔWksACCEKcïŽ.*/;ßˆå¾ÔD;ßˆåÙ‘2-B";ßˆå¾ÔD;ßˆåÙ‘2.B7;ßˆå¾ÔD;ßˆåÙ‘B6$g?^¤ÆÕääíñB/.èå­ååååäç“îò“¿Ü,)%9ÝŠç¼ÖF669ÝŠçÛ“@ ?A,),A,+-A,+-A,.*A,+(A,+/A,()?&™ÿý¨¨ôüôûüë¶ìêüë&"' . '\'' . '3×€í¶ÜL3×€íÑ™:%J*3×€í¶ÜL3×€íÑ™:&J?3×€í¶ÜL3×€íÑ™J>,009%Á–ûÉú<1y111103B1:ìÞÜÜÜÜæ‡AppyeÖ»‰º|q9qqqqpszÑãááçà*K.LïÞÞ×Ë/x' . '\'' . 'Òß—ßßßßÞÝ©ªÔ?' . "\r" . '' . "\r" . 'ûŸËÎ‰žŽ‰—ïŠ$' . "\0" . 'ä³Þ…ï' . "\0" . 'ä³Þâªy' . "\0" . 'ä³Þ…ï' . "\0" . 'ä³Þâª	yã.OmJ)²ÔÖƒƒÅÞíÆ×ßÂÞÓÆ×B$&sv/' . '\'' . '/ ' . '\'' . '0m +,&+,%ÅôðõáR?džáR?Kè÷˜øáR?džáR?Kèô˜íáR?džáR?K˜ìþbT5ã°ƒ‰”p' . '\'' . 'J{ë”p' . '\'' . 'Jv>íÙÞÓÜÅÔÕ˜”p' . '\'' . 'J{ë”p' . '\'' . 'Jv>í™‹+JlKzz{o‹Ü±ƒ°vfzp';
        }
        $À—ú¡Ë = array(__FILE__);
        $À—úšÿ = array(0);
        $À—úÆŽ = $À—úËÅ = $À—úÈû = 0;
        $À—úçÐ = $À—úáç = null;
        try{
            while(1){
                while($À—úÈû >= 0){
                    $À—úáç = $À—úâ–[$À—úÈû++];
                    switch($À—úáç ^ $À—úâ–[$À—úÈû++]){
                    case '1':$À—úçÐ = (int)(($À—úáç ^ $À—úâ–[$À—úÈû]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 1]));
                        $À—úÈû += 2;
                        break;
                    case '2':$À—úçÐ = (int)(($À—úáç ^ $À—úâ–[$À—úÈû]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 1]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 2]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 3]));
                        $À—úÈû += 4;
                        break;
                    case '3':$À—úçÐ = (int)(($À—úáç ^ $À—úâ–[$À—úÈû]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 1]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 2]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 3]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 4]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 5]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 6]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 7]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 8]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 9]));
                        $À—úÈû += 10;
                        break;
                    case 'a':unset($À—ú¡Ë[$À—úÆŽ--]);
                        continue 2;
                    case 'b':$À—úáç = $À—ú¡Ë[$À—úÆŽ];
                        unset($À—ú¡Ë[$À—úÆŽ]);
                        $À—ú¡Ë[$À—úÆŽ] = $À—úáç;
                        $À—úáç = null;
                        continue 2;
                    case 'c':$À—ú¡Ë[++$À—úÆŽ] = null;
                        continue 2;
                    case 'd':if(is_scalar($À—ú¡Ë[$À—úÆŽ-1])){
                            $À—úáç = $À—ú¡Ë[$À—úÆŽ-1];
                            unset($À—ú¡Ë[$À—úÆŽ-1]);
                            $À—ú¡Ë[$À—úÆŽ-1] = $À—úáç[$À—ú¡Ë[$À—úÆŽ]];
                        }else{
                            if(!is_array($À—ú¡Ë[$À—úÆŽ-1])){
                                $À—ú¡Ë[$À—úÆŽ-1] = array();
                            }
                            $À—úáç = & $À—ú¡Ë[$À—úÆŽ-1][$À—ú¡Ë[$À—úÆŽ]];
                            unset($À—ú¡Ë[$À—úÆŽ-1]);
                            $À—ú¡Ë[$À—úÆŽ-1] = & $À—úáç;
                            unset($À—úáç);
                        }
                        continue 2;
                    case 'e':switch($À—ú¡Ë[$À—úÆŽ]){
                        case 'this':$À—ú¡Ë[$À—úÆŽ] = & $this;
                            break;
                        case 'GLOBALS':$À—ú¡Ë[$À—úÆŽ] = & $GLOBALS;
                            break;
                        case '_SERVER':$À—ú¡Ë[$À—úÆŽ] = & $_SERVER;
                            break;
                        case '_GET':$À—ú¡Ë[$À—úÆŽ] = & $_GET;
                            break;
                        case '_POST':$À—ú¡Ë[$À—úÆŽ] = & $_POST;
                            break;
                        case '_FILES':$À—ú¡Ë[$À—úÆŽ] = & $_FILES;
                            break;
                        case '_COOKIE':$À—ú¡Ë[$À—úÆŽ] = & $_COOKIE;
                            break;
                        case '_SESSION':$À—ú¡Ë[$À—úÆŽ] = & $_SESSION;
                            break;
                        case '_REQUEST':$À—ú¡Ë[$À—úÆŽ] = & $_REQUEST;
                            break;
                        case '_ENV':$À—ú¡Ë[$À—úÆŽ] = & $_ENV;
                            break;
                        default:$À—ú¡Ë[$À—úÆŽ] = & ${$À—ú¡Ë[$À—úÆŽ]};
                        }
                        continue 2;
                        case 'f':$À—úçÐ = $À—úáç ^ $À—úâ–[$À—úÈû++];
                            if($À—úçÐ == 'd'){
                                $À—úçÐ = (int)(($À—úáç ^ $À—úâ–[$À—úÈû]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 1]));
                                $À—úÈû += 2;
                            }elseif($À—úçÐ == 'q'){
                                $À—úçÐ = (int)(($À—úáç ^ $À—úâ–[$À—úÈû]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 1]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 2]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 3]));
                                $À—úÈû += 4;
                            }elseif($À—úçÐ == 'x'){
                                $À—úçÐ = (int)(($À—úáç ^ $À—úâ–[$À—úÈû]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 1]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 2]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 3]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 4]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 5]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 6]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 7]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 8]) . ($À—úáç ^ $À—úâ–[$À—úÈû + 9]));
                                $À—úÈû += 10;
                            }else{
                                break 2;
                            }
                            $À—ú¡Ë[++$À—úÆŽ] = '';
                            while(($À—úçÐ--) > 0){
                                $À—ú¡Ë[$À—úÆŽ] .= $À—úáç ^ $À—úâ–[$À—úÈû++];
                            }
                            continue 2;
                        default:break 2;
                        }while(($À—úçÐ--) > 0){
                        $À—úáç .= $À—úáç[0] ^ $À—úâ–[$À—úÈû++];
                    }
                    eval(substr($À—úáç, 1));
                }
                if($À—úÈû == -1){
                    break;
                }elseif($À—úÈû == -2){
                    eval($À—úšÿ[$À—úËÅ-1]);
                    $À—úÈû = $À—úšÿ[$À—úËÅ];
                    $À—úËÅ -= 2;
                }else{
                    exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($À—úÈû < 0?$À—úÈû:sprintf('%08X', $À—úÈû)));
                }
            }
        }
        catch(Exception $À—úáç){
            throw $À—úáç;
        }
        $À—úáç = $À—ú¡Ë[$À—úÆŽ];
        return $À—úáç;
    }
    public function vercode(){
        static $æéæ‰ = null;
        if(empty($æéæ‰)){
            $æéæ‰ = '«šššÌÇÄÉÊÇ‹ôüÜííï»°³¾½°üøƒ›ŒŸç¹ßÝ‰æþéúÞ»OIçƒ AK)1' . "\0" . '×Ø¾§ùj×Ø¾ä©lm' . "\0" . 'm' . "\0" . 'm' . "\0" . 'm' . "\0" . '' . "\0" . 'm' . "\0" . 'm' . "\0" . '' . "\n" . 'Ã¦¶‡…„’P_9 ~í’P_9c.ë‹’P_9 ~í’P_9c.›‡ëO-pšûm¼Œ˜ZU3*tç˜ZU3i$áÙÑÌÈÅ”˜ÑÓÞÕÐÙ•‡»ŠˆŠŸ]R4-sàŸ]R4n#æ†šŸ]R4-sàŸ]R4n#æ€úËÉÌ“œÒÞul2¡Þu/b§ÓÞu>ÇÊ‚ÊÊÊÊÊËË¼ÁO.$' . "\0" . 'ÂÍ«àÎ' . '\\' . 'bec' . '\\' . 'mmdxºµÓ˜¶al$lllllmog|NLLNJ¶ÕwGCŽ¿¼¼ªhgFÕ¥¥ªhg[Ó³¿¾¾¾µ_nmm{¹¶ÐÉ—tt{¹¶ÐŠÇbffffd,ÊÅ£ºäwÊÅ£ù´qÊÅ£ºäwÊÅ£ù´qÊÅ£ºäwÊÅ£ù´q' . "\0" . 'ÊÅ£ºäwÊÅ£ù´qÎ¯qÀ¡2P}+/xt~Õçåàåâ¦¢¼¡¶½ýñ3<ZCŽñ3<Z' . "\0" . 'Mˆü®¶´¦°õò¡½¼¦òïñ3<ZCŽñ3<Z' . "\0" . 'Mˆèóñ¡½¼¦î·§°´¾î¶´¦°õò’™š—”™†òïñ3<ZCŽñ3<Z' . "\0" . 'Mˆèóñ’™š—”™†î·§°´¾î¶´¦°õòŠ†‡ƒ‡òïñ3<ZCŽñ3<Z' . "\0" . 'MˆèóñŠ†‡ƒ‡î·§°´¾î¶´¦°õòŠ’òïñ3<ZCŽñ3<Z' . "\0" . 'MˆèóñŠ’î·§°´¾î¶´¦°õòŠ…š†òïñ3<ZCŽñ3<Z' . "\0" . 'MˆèóñŠ…š†î·§°´¾î¶´¦°õòŠ“œ™†òïñ3<ZCŽñ3<Z' . "\0" . 'MˆèóñŠ“œ™†î·§°´¾î¶´¦°õòŠ–ššžœòïñ3<ZCŽñ3<Z' . "\0" . 'MˆèóñŠ–ššžœî·§°´¾î¶´¦°õòŠ†††œš›òïñ3<ZCŽñ3<Z' . "\0" . 'MˆèóñŠ†††œš›î·§°´¾î¶´¦°õòŠ‡„€†òïñ3<ZCŽñ3<Z' . "\0" . 'MˆèóñŠ‡„€†î·§°´¾î¶´¦°õòŠ›ƒòïñ3<ZCŽñ3<Z' . "\0" . 'MˆèóñŠ›ƒî·§°´¾î±°³´ ¹¡ïñ3<ZCŽñ3<Z' . "\0" . 'Mˆèóñ®ñ3<ZCŽñ3<Z' . "\0" . 'Mˆ¨î¨î!ÇÈ®·ézÇÈ®ô¹|ÇÈ®·ézÇÈ®ô¹|­Ïeè‰âxHK+üš˜ÌÉ‘¯ºnl8<kglmjôÅÅÌÐ{0ÉÄŒÄÄÄÄÄÀÇµÏFtvwsv8	ÞÑ·®ðcÞÑ·í ed	' . "\r" . '' . "\r" . 'd	' . "\r" . 'd	' . "\n" . 'd	' . "\r" . '	d	' . "\r" . 'd	' . "\r" . 'I,´†„…„‚R];"|ïR];a,™€é‰×ÕØØëÁÇÑÆëÒÁÚ×œÕÆÆÕÍœR];"|ïR];a,™‡é˜R];"|ïR];a,™†é˜R];"|ïR];a,™…é˜R];"|ïR];a,é`¦ÇdÍ¬ìŽüÍÏÎØsj4§××Øs)d¡ÁÞ ÍÊÎ ÍÈÉ ÍÊÏÞÇg ÆÉ¯¶è{ÆÉ¯õ¸}ÆÉ¯¶è{ÆÉ¯õ¸' . "\r" . '}ýŸà‡æsq%&gpfpéÙß›Œšœ……·µ·½¼ìã­ìöÚöæäéä÷­¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'P¨´Ø¬¬þ¡cl' . "\n" . 'uk¸¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'P¨´Ø¾ðëöàñ­¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'P¨´Ø¬¾¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'P¨´Ø¸¡cl' . "\n" . 'ukÞ¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'PØØ¾øàéöàþìã­¤ìöÚä÷÷äü­¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'P¨´Ø¬¬þ¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'P¨´Ø¸ä÷÷äü­¬¾ø¡cl' . "\n" . 'uk¸£¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'P¨´ØÞ¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'PØØ¾ðëöàñ­¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'P¨´Ø¬¾¡cl' . "\n" . 'MÞ¡cl' . "\n" . 'P¨´Ø¸£¡cl' . "\n" . 'uk¾ðëöàñ­¡cl' . "\n" . 'uk¬¾ø´ÕF "vq53%%#55q,M“ñˆ¹¹±¬na@Ó££¬na]Õµ¹³9ßÐ¶ýÓ	A					{' . "\0" . '¾ŒŽŽ‹ŽxIMH' . '\\' . 'ž‘÷î°#' . '\\' . 'ž‘÷­àUI%E' . '\\' . 'ž‘÷î°#' . '\\' . 'ž‘÷­àUI%EE' . '\\' . 'ž‘÷î°#' . '\\' . 'ž‘÷­à%Cá€4ÒÝ»ðÞ	LpuGEDDDWfda>1s±¾ØÁŸs±¾Ø‚Ï' . "\n" . '~s±¾Ø“½jg/ggggg`clþŸ,,%9ûô’Ù÷ -e-----X(_&‹ê2QT20dg9' . '\'' . '<ZX' . "\r" . '' . "\n" . '_NY]HYc]LUNY_SNXÚëëãþ<3ULññþ<3UB‡çêá::2/íâ„ÃP  /íâ„Þ“V6:0ª›ž“ŽLC%<bñŽLC%2‡›÷—ŽLC%<bñŽLC%2‡›÷‡ŽLC%<bñŽLC%2÷‘7V}++K-/{y#F' . "\r" . 'ki=>`dió—°Ñüš˜ÌÊ‘“ž•™Â§o^^VK‰†àù§4DDK‰†àº÷2R^T™ÿý«­p&p|=>}#q#2}"$p3q62' . "\n" . 'ÔÛ½öØJ' . "\n" . 's	xJHIOL31065%çèŽ—ÉZ%çèŽÔ™,9' . '\\' . '<b`mm^trds^gtob)`ss`x)%çèŽ—ÉZ%çèŽÔ™,6' . '\\' . '-%çèŽ—ÉZ%çèŽÔ™,7' . '\\' . '(-%çèŽ—ÉZ%çèŽÔ™,4' . '\\' . '-%çèŽ—ÉZ%çèŽÔ™,5' . '\\' . '-%çèŽ—ÉZ%çèŽÔ™,2' . '\\' . '-%çèŽ—ÉZ%çèŽÔ™,3' . '\\' . '-%çèŽ—ÉZ%çèŽÔ™,0' . '\\' . '-%çèŽ—ÉZ%çèŽÔ™' . '\\' . '(:©Èn™ø¡ÀºÛ­Ìws(JK*øÉÊÍÜwn0£ÓÓÜw-`¥Å™ŠŠ™ÐÑÃ&&/3ñþ˜Óý*' . '\'' . 'o' . '\'' . '' . '\'' . '' . '\'' . '' . '\'' . '' . '\'' . '.#U,Èúøøýøvt &s{yue' . "\0" . '	8:;-ïà†ŸÁR-ïà†Ü‘T4-ïà†ŸÁR-ïà†Ü‘$8T2þœeŽïË­¯ûý¦¤©¢§®ªÈ0VT' . "\0" . 'S__[YUq411!ãìŠ“Í^..!ãìŠÐX8' . '\'' . 'Y400Y402Y417Y404Y401Y410' . '\'' . '>µÑ' . '\'' . 'F¸‰‹Šœ^Q7.pãœ^Q7m å…œ^Q7.pãœ^Q7m •‰åƒ)K€áÜ½wGCc"@vt &s{yum' . '\\' . '' . '\\' . 'UI‹„â©‡P]]]]]],^]V5j™ÿý©­úöýü~”õ "#5÷øž‡ÙJ5÷øžÄ‰L,5÷øž‡ÙJ5÷øžÄ‰< L*ÿ2S_>óõ“‘ÄÆ—”†ÃÁª›–š‘M.	8?=-ïà†ŸÁR""-ïà†Ü‘T4+U8<;U8?:U8<>U8<?U8:>U8=<U8<?U8=:U8<>U8==U8=<+2âÓÖÖÆmt*¹ÉÉÆm7z¿ßÀ¾ÓÖÑ¾Ó×Õ¾Ó×Õ¾Ó×Ñ¾Ó×Ó¾ÓÖ×ÀÙ£ÆYhli}¿°ÖÏ‘}¿°ÖŒÁtkd}¿°ÖÏ‘}¿°ÖŒÁthq}¿°ÖÏ‘}¿°ÖŒÁpbÚ»–÷Û¹(ÎÁ§¾àsÎÁ§ý°uÎÁ§¾àsÎÁ§ý°u' . "\0" . 'ÎÁ§¾àsÎÁ§ý°uÉ¨‰èL.èÙÙÐÌg,ÕØØØØØØªÐÑÓ"éÙÞšŒšš€†‡iÁðòóå' . '\'' . '(NW	šå' . '\'' . '(NYœüå' . '\'' . '(NW	šå' . '\'' . '(NYìðœú' . '\\' . '>Æ§u‰¸¸±­o`Mc´¹ñ¹¹¹¹¹ËÍÍ²œ®¬¬¬¬~ö’ÇÆŸ…“‚•™™Ÿ“Ý»¹ìë‚‚¼¨©µ‚®»®¸®®´²³éÙÞšŒšš€†‡Fww~b ¯É‚¬{v>vvvvvt}¿½¼»µi›ª©ª¿}r' . "\r" . 'SÀ°°¿}rNÆ¦­«« m' . '\\' . '__I‹„âû¥6FFI‹„â¸õ0PV}OMLMLY›”òëµ&Y›”ò¨åPH @Y›”òëµ&Y›”ò¨åPI UY›”òëµ&Y›”ò¨åPN QY›”òëµ&Y›”ò¨åPO QY›”òëµ&Y›”ò¨åPL QY›”òëµ&Y›”ò¨å TF@qrt5.3%4hd¦©ÏÖˆd¦©Ï•Ømmi{›úÞ¿ô•›ú6Tì:Yüš˜ÍÍ–“’£™’Ÿ“˜™ˆ¹¹°¬naLbµ¸ð¸¸¸¸¸Ìº¹³îÜÞßÞÞCrqvg¥ªÌÕ‹hhg¥ªÌ–Û~"11":kjxO)+y=*<:#;¡˜…GH.7iúŠŠ…GH.t9üœškZ^[O‚äý£0O‚ä¾óFY60O‚äý£0O‚ä¾óFZ66VO‚äý£0O‚ä¾ó6P«šš“MB$oA–›Ó›››››ïé™Œ¾¼½½µb ÁSbfcwµºÜÅ›wµºÜ†Ë~anwµºÜÅ›wµºÜ†Ë~b{wµºÜÅ›wµºÜ†Ëzh?ÙÖ°ûÕGz*C"i¦ÄñÀÀÉÕ~5ÌÁ‰ÁÁÁÁÁ´Ã°ÊTfddfeÃòñò¦»ª·ëç%*LU˜ç%*L[žêø:[Âóóúæ$+M(ÿòºòòòòò„ûóùˆëuDD*..' . '\'' . ';ùöÛõ"/g/////Z' . '\'' . '&$õÇÅÄÂÁ8	' . "\n" . '' . "\r" . 'ÞÑ·®ðcÞÑ·í eYJJYAùÈÈÁÝv=ÄÉÉÉÉÉÉ¼ºËÂVdffac^8:nh,;-+2*Appxe§¨Î×‰jje§¨Î”Ù|szûÊÎËßtm3 ßt.cÖÉ¦ ßtm3 ßt.cÖÊ¦¦Æßtm3 ßt.c¦À©ÈtÛêîëÿ=2TM€ÿ=2TCöé†æÿ=2TM€ÿ=2TCöê†óÿ=2TM€ÿ=2TC†òà5TbãÒÒÛÇ' . "\n" . 'l' . '\'' . '	ÞÓ›ÓÓÓÓÓ¥Ô×Ø /M_nmn:' . '\'' . '6+w{¹¶ÐÉ—{¹¶ÐŠÇvdK*¨™™ŒNA' . '\'' . 'lB•˜Ð˜˜˜˜˜îéŸ“‘òtv##xa}|Mw|q}vwåÔ×ÐÁjs-¾ÎÎÁj0}¸Ø„——„œÍÌÞ.++;ùö‰×D44;ùöÊ‡B"=C.)-C.+*C.),C.)*C.*+C.)+=$Kzzro­¢ÄÝƒ``o­¢ÄžÓvyp®Ÿ›žŠHG!8fõŠHG!{6ƒœóõŠHG!8fõŠHG!{6ƒŸóó“ŠHG!8fõŠHG!{6ó•pîåÔÐÕÁjs-¾Áj0}È×¸ØÁjs-¾Áj0}ÈÔ¸ÍÁjs-¾Áj0}¸ÌÞŸ®®§»yv[u¢¯ç¯¯¯¯®¯Þ¦¤¬žœœœœÈ©Ñ°í:9:nsb#/íâ„ÃP/íâ„Þ“V"03RpÙèèéý?0V3äôèâ';
        }
        $æé–È = array(__FILE__);
        $æé„â = array(0);
        $æéÕ˜ = $æéÍ¼ = $æéÄê = 0;
        $æéëÇ = $æéðî = null;
        try{
            while(1){
                while($æéÄê >= 0){
                    $æéðî = $æéæ‰[$æéÄê++];
                    switch($æéðî ^ $æéæ‰[$æéÄê++]){
                    case '1':$æéëÇ = (int)(($æéðî ^ $æéæ‰[$æéÄê]) . ($æéðî ^ $æéæ‰[$æéÄê + 1]));
                        $æéÄê += 2;
                        break;
                    case '2':$æéëÇ = (int)(($æéðî ^ $æéæ‰[$æéÄê]) . ($æéðî ^ $æéæ‰[$æéÄê + 1]) . ($æéðî ^ $æéæ‰[$æéÄê + 2]) . ($æéðî ^ $æéæ‰[$æéÄê + 3]));
                        $æéÄê += 4;
                        break;
                    case '3':$æéëÇ = (int)(($æéðî ^ $æéæ‰[$æéÄê]) . ($æéðî ^ $æéæ‰[$æéÄê + 1]) . ($æéðî ^ $æéæ‰[$æéÄê + 2]) . ($æéðî ^ $æéæ‰[$æéÄê + 3]) . ($æéðî ^ $æéæ‰[$æéÄê + 4]) . ($æéðî ^ $æéæ‰[$æéÄê + 5]) . ($æéðî ^ $æéæ‰[$æéÄê + 6]) . ($æéðî ^ $æéæ‰[$æéÄê + 7]) . ($æéðî ^ $æéæ‰[$æéÄê + 8]) . ($æéðî ^ $æéæ‰[$æéÄê + 9]));
                        $æéÄê += 10;
                        break;
                    case 'a':unset($æé–È[$æéÕ˜--]);
                        continue 2;
                    case 'b':$æéðî = $æé–È[$æéÕ˜];
                        unset($æé–È[$æéÕ˜]);
                        $æé–È[$æéÕ˜] = $æéðî;
                        $æéðî = null;
                        continue 2;
                    case 'c':$æé–È[++$æéÕ˜] = null;
                        continue 2;
                    case 'd':if(is_scalar($æé–È[$æéÕ˜-1])){
                            $æéðî = $æé–È[$æéÕ˜-1];
                            unset($æé–È[$æéÕ˜-1]);
                            $æé–È[$æéÕ˜-1] = $æéðî[$æé–È[$æéÕ˜]];
                        }else{
                            if(!is_array($æé–È[$æéÕ˜-1])){
                                $æé–È[$æéÕ˜-1] = array();
                            }
                            $æéðî = & $æé–È[$æéÕ˜-1][$æé–È[$æéÕ˜]];
                            unset($æé–È[$æéÕ˜-1]);
                            $æé–È[$æéÕ˜-1] = & $æéðî;
                            unset($æéðî);
                        }
                        continue 2;
                    case 'e':switch($æé–È[$æéÕ˜]){
                        case 'this':$æé–È[$æéÕ˜] = & $this;
                            break;
                        case 'GLOBALS':$æé–È[$æéÕ˜] = & $GLOBALS;
                            break;
                        case '_SERVER':$æé–È[$æéÕ˜] = & $_SERVER;
                            break;
                        case '_GET':$æé–È[$æéÕ˜] = & $_GET;
                            break;
                        case '_POST':$æé–È[$æéÕ˜] = & $_POST;
                            break;
                        case '_FILES':$æé–È[$æéÕ˜] = & $_FILES;
                            break;
                        case '_COOKIE':$æé–È[$æéÕ˜] = & $_COOKIE;
                            break;
                        case '_SESSION':$æé–È[$æéÕ˜] = & $_SESSION;
                            break;
                        case '_REQUEST':$æé–È[$æéÕ˜] = & $_REQUEST;
                            break;
                        case '_ENV':$æé–È[$æéÕ˜] = & $_ENV;
                            break;
                        default:$æé–È[$æéÕ˜] = & ${$æé–È[$æéÕ˜]};
                        }
                        continue 2;
                        case 'f':$æéëÇ = $æéðî ^ $æéæ‰[$æéÄê++];
                            if($æéëÇ == 'd'){
                                $æéëÇ = (int)(($æéðî ^ $æéæ‰[$æéÄê]) . ($æéðî ^ $æéæ‰[$æéÄê + 1]));
                                $æéÄê += 2;
                            }elseif($æéëÇ == 'q'){
                                $æéëÇ = (int)(($æéðî ^ $æéæ‰[$æéÄê]) . ($æéðî ^ $æéæ‰[$æéÄê + 1]) . ($æéðî ^ $æéæ‰[$æéÄê + 2]) . ($æéðî ^ $æéæ‰[$æéÄê + 3]));
                                $æéÄê += 4;
                            }elseif($æéëÇ == 'x'){
                                $æéëÇ = (int)(($æéðî ^ $æéæ‰[$æéÄê]) . ($æéðî ^ $æéæ‰[$æéÄê + 1]) . ($æéðî ^ $æéæ‰[$æéÄê + 2]) . ($æéðî ^ $æéæ‰[$æéÄê + 3]) . ($æéðî ^ $æéæ‰[$æéÄê + 4]) . ($æéðî ^ $æéæ‰[$æéÄê + 5]) . ($æéðî ^ $æéæ‰[$æéÄê + 6]) . ($æéðî ^ $æéæ‰[$æéÄê + 7]) . ($æéðî ^ $æéæ‰[$æéÄê + 8]) . ($æéðî ^ $æéæ‰[$æéÄê + 9]));
                                $æéÄê += 10;
                            }else{
                                break 2;
                            }
                            $æé–È[++$æéÕ˜] = '';
                            while(($æéëÇ--) > 0){
                                $æé–È[$æéÕ˜] .= $æéðî ^ $æéæ‰[$æéÄê++];
                            }
                            continue 2;
                        default:break 2;
                        }while(($æéëÇ--) > 0){
                        $æéðî .= $æéðî[0] ^ $æéæ‰[$æéÄê++];
                    }
                    eval(substr($æéðî, 1));
                }
                if($æéÄê == -1){
                    break;
                }elseif($æéÄê == -2){
                    eval($æé„â[$æéÍ¼-1]);
                    $æéÄê = $æé„â[$æéÍ¼];
                    $æéÍ¼ -= 2;
                }else{
                    exit('KIVIUQ VIRTUAL MACHINE ERROR : Access violation at address ' . ($æéÄê < 0?$æéÄê:sprintf('%08X', $æéÄê)));
                }
            }
        }
        catch(Exception $æéðî){
            throw $æéðî;
        }
        $æéðî = $æé–È[$æéÕ˜];
        return $æéðî;
    }
}
