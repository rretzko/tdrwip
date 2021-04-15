<?php

namespace Database\Seeders;

use App\Models\Nonsubscriberemail;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriberEmailSeeder extends Seeder
{
    private $seeds;

    public function __construct()
    {
        //instantiate $this->seeds with teacher data
        $this->seeds = $this->buildSeeds();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        foreach($this->seeds AS $seed){

            $model = new Nonsubscriberemail();

            $model->user_id = $seed[0];
            $model->emailtype_id = $seed[1];
            $model->email = $seed[2];
            $model->created_at = $now;
            $model->updated_at = $now;

            $model->save();
        }
    }

    private function buildSeeds()
    {
        return  [
            [7186,2,'12beajar@gmail.com'],
            [7126,1,'24gpiccione@hazlet.org'],
            [15,2,'aaronkrasting@yahoo.com'],
            [1,1,'abaldasserini@marsd.org'],
            [7195,1,'abarney@lakewoodpiners.org'],
            [2,1,'abernard@pgcpschools.org'],
            [7198,1,'abotbyl@monroetwp.k12.nj.us'],
            [3,1,'Acampanini@wtps.org'],
            [4,1,'acaravano@fairlawnschools.org'],
            [7203,1,'acarrillo@gehrhsd.net'],
            [7204,1,'acerminara@pennsgrove.k12.nj.us'],
            [20,2,'acmalloy@hotmail.com'],
            [5,1,'aconti@belvideresd.org'],
            [6,1,'adam.good@ebnet.org'],
            [14,2,'adam.jarvela@gmail.com'],
            [7,1,'adam_herskowitz@nbpsnj.net'],
            [284,2,'adamsm3141@gmail.com'],
            [8115,1,'Adan_Johnson63@hotmail.com'],
            [8,1,'adiiori1@gmail.com'],
            [8,2,'adiioriobird@whrhs.org'],
            [9,1,'admin@njyouthchorus.org'],
            [10,1,'aemelianoff@newarka.edu'],
            [11,1,'afinck@nhvweb.net'],
            [12,1,'afoster@newtonnj.org'],
            [398,2,'afs2011@hotmail.com'],
            [13,1,'Agopal@ebnet.org'],
            [14,1,'ajarvela@springfieldschool.org'],
            [10,2,'ajlarkey@aol.com'],
            [7267,2,'ajtag21@gmail.com'],
            [15,1,'akrastin@paulsboro.k12.nj.us'],
            [16,1,'alaine.bolton@woodbridge.k12.nj.us'],
            [7193,1,'albader@haddonfield.k12.nj.us'],
            [17,1,'aldo.aranzulla@sbschools.org'],
            [18,1,'alesser@burlington-nj.net'],
            [33,2,'alexanderyounger@gmail.com'],
            [19,1,'alimaldi@frhsd.com'],
            [4,2,'alison.caravano@gmail.com'],
            [7255,2,'aljo2002@aol.com'],
            [7208,2,'allegracounsellor@gmail.com'],
            [20,1,'amalloy@olmc-school.org'],
            [23,2,'amarkminter@gmail.com'],
            [21,1,'amelson@mainlandregional.net'],
            [21,2,'amelson802@gmail.com'],
            [22,1,'amichaels@peddie.org'],
            [23,1,'aminter@ewingboe.org'],
            [16,2,'ampbmusik@msn.com'],
            [24,1,'amy_six@nplainfield.org'],
            [7198,2,'Amyartese@hotmail.com'],
            [24,2,'amysix6@gmail.com'],
            [150,2,'amyveronica8@gmail.com'],
            [25,1,'andrea.c.cahill@gmail.com'],
            [7216,1,'Andrea.dixon@millville.org'],
            [7216,2,'Andrealdixon@gmail.com'],
            [26,1,'andrew.denicola@edison.k12.nj.us'],
            [18,2,'andrew.lesser@yahoo.com'],
            [93,2,'anna.dachille@gmail.com'],
            [27,1,'anne.paynter@hca.org'],
            [2,2,'antonina.bernard.music@gmail.com'],
            [7249,1,'aowens@gloucestertownshipschools.org'],
            [345,2,'apalmentieri@comcast.net'],
            [30,2,'arginesafari@gmail.com'],
            [7203,2,'aricarrillo1234@gmail.com'],
            [7255,1,'ariddle@mtephraimschools.com'],
            [28,1,'arielle.klein@monroe.k12.nj.us'],
            [28,2,'arielle.siegel@monroe.k12.nj.us'],
            [7192,1,'aristizabal@upperschools.org'],
            [29,1,'Arothkopf@nutleyschools.org'],
            [30,1,'asafari@pascack.org'],
            [12,2,'ashley.lynne.foster@gmail.com'],
            [7267,1,'ataglairino@pemb.org'],
            [31,1,'atan@trschools.com'],
            [32,1,'avallies@mlschools.org'],
            [3,2,'aversaggi@icloud.com'],
            [7313,1,'avitarelli@msemail.org'],
            [7272,1,'awentz@lacschool.org'],
            [33,1,'ayounger@sterling.k12.nj.us'],
            [34,1,'Baconb@cinnaminson.com'],
            [45,2,'barbararetzko@hotmail.com'],
            [35,1,'barryj@nvnet.org'],
            [36,1,'battersj@eht.k12.nj.us'],
            [7193,2,'bbader1218@gmail.com'],
            [37,1,'bburke@twpunionschools.org'],
            [38,1,'bcooper@chclc.org'],
            [39,1,'beanefoxs@lcmrschools.com'],
            [7196,1,'beerek@newegypt.us'],
            [363,2,'belabart71@gmail.com'],
            [40,1,'berchtoldd@hamiltonschools.org'],
            [41,1,'bergers@cinnaminson.com'],
            [37,2,'bernadettedelia@gmail.com'],
            [107,2,'bethdprins@gmail.com'],
            [135,2,'bethmoore124@gmail.com'],
            [42,1,'Bfarmer@camden.k12.nj.us'],
            [7229,1,'bgross@collsk12.org'],
            [7229,2,'bgross511@gmail.com'],
            [433,2,'billyerkes68@gmail.com'],
            [159,2,'bjpharrison72@gmail.com'],
            [43,1,'bkain@chclc.org'],
            [6923,1,'bkrajcik@rbrhs.org'],
            [44,1,'bmoore2@lrhsd.org'],
            [242,2,'bnkjohns@yahoo.com'],
            [45,1,'bretzko@bernardsboe.com'],
            [46,1,'brian.verdi@edison.k12.nj.us'],
            [48,2,'brianschkeeper@gmail.com'],
            [52,2,'brianwilliamsemail@gmail.com'],
            [47,1,'britt@rutgersprep.org'],
            [174,2,'brzozowski.john@gmail.com'],
            [48,1,'bschkeeper@ocsdnj.org'],
            [49,1,'Bschneider@elsinboroschool.org'],
            [6690,1,'bscotton@materdeiprep.org'],
            [50,1,'btoth@ebnet.org'],
            [38,2,'burjiscoopermusic@gmail.com'],
            [8419,1,'bverryt@908devices.com'],
            [51,1,'bvierschilling@summit.k12.nj.us'],
            [52,1,'bwilliams@robbinsville.k12.nj.us'],
            [53,1,'bwrigley@pitman.k12.nj.us'],
            [80,2,'calvarywoman@gmail.com'],
            [61,2,'candacelaricci@gmail.com'],
            [54,1,'cascione.nicole@gmail.com'],
            [58,2,'catherinechmbrs@gmail.com'],
            [89,2,'cathyweir56@gmail.com'],
            [55,1,'cbader@clearviewregional.edu'],
            [56,1,'cbreitzman@arcsgalloway.org'],
            [7269,2,'Cbthomas@gmail.com'],
            [57,1,'ccaldwell@cccrusader.org'],
            [57,2,'ccaldwell222@comcast.net'],
            [58,1,'cchambers@acitech.org'],
            [7205,1,'Ccollins@holyspirithighschool.com'],
            [7210,1,'Ccuperwich@smlschool.org'],
            [59,1,'cdestefano@wdeptford.k12.nj.us'],
            [60,1,'cdwyer@materdeiprep.org'],
            [61,1,'cfitzgerald@trschools.com'],
            [62,1,'cflud@acboe.org'],
            [273,2,'cgale13@gmail.com'],
            [63,1,'cgraff@wdeptford.k12.nj.us'],
            [64,1,'chartung@collsk12.org'],
            [62,2,'chazflud@me.com'],
            [55,2,'chelseabader12@gmail.com'],
            [65,1,'chensel@marsd.org'],
            [56,2,'cherylbreitzman@gmail.com'],
            [43,2,'chiefbk2000@yahoo.com'],
            [66,1,'chieffo@hainesport.k12.nj.us'],
            [229,2,'choirboy99@optonline.net'],
            [67,1,'christine.scott@woodbridge.k12.nj.us'],
            [68,1,'christopher.nappa@plps.org'],
            [69,1,'chuitze@hotmail.com'],
            [70,1,'Cintrocaso@collsk12.org'],
            [71,1,'cioffi.d@woodstown.org'],
            [64,2,'cjhartung@gmail.com'],
            [74,2,'claire.r.ma@gmail.com'],
            [72,1,'cloeffler@trschools.com'],
            [73,1,'clombardo@pitman.k12.nj.us'],
            [74,1,'cma@veronaschools.org'],
            [75,1,'cmcallister@elsinboroschool.org'],
            [76,1,'cmolnar@wallkillvrhs.org'],
            [76,2,'cmolnarmusic@gmail.com'],
            [8442,1,'cmorillo@bbbsefl.org'],
            [91,2,'cmwsing@gmail.com'],
            [79,2,'cncif@yahoo.com'],
            [7205,2,'Cncollins3@verizon.net'],
            [339,2,'cnowmos@gmail.com'],
            [7185,2,'coa215@verizon.net'],
            [77,1,'colin.oettle@ww-p.org'],
            [78,1,'connw@stratford.k12.nj.us'],
            [7206,1,'corrym@evesham.k12.nj.us'],
            [7207,2,'cosme.crystal1@gmail.com'],
            [7207,1,'Cosme.voice@gmail.com'],
            [7208,1,'counsellora@harrisontwp.k12.nj.us'],
            [81,2,'courtneyrousak@gmail.com'],
            [236,2,'coxykate17@gmail.com'],
            [79,1,'cpalomba@wayneschools.com'],
            [80,1,'cpinto@pemb.org'],
            [70,2,'Cristincharlton@gmail.com'],
            [7190,1,'crivera8@tdr.com'],
            [81,1,'crousak@pv-eagles.org'],
            [82,1,'csabol@monmouthregional.net'],
            [83,1,'csomershoe@veccnj.org'],
            [84,1,'cstanton@westfieldnjk12.org'],
            [85,1,'ctedesco@mtlaurelschools.org'],
            [1,2,'cucitrice2018@gmail.com'],
            [8141,1,'cunhabug605@gmail.com'],
            [8141,2,'curmudgeon@comcast.net'],
            [87,1,'cvaughn@springfieldschool.org'],
            [88,1,'cvitale@westfieldnjk12.org'],
            [89,1,'cweir@springfieldschool.org'],
            [90,1,'cwilhjelm@pascack.org'],
            [91,1,'cwilson@pthsd.net'],
            [85,2,'cynthiatedesco12@gmail.com'],
            [92,1,'czajdel@gehrhsd.net'],
            [93,1,'dachillea@nvnet.org'],
            [373,2,'dale.roeck@gmail.com'],
            [7211,1,'dalfonsod@middletwp.k12.nj.us'],
            [94,1,'daltonj@krsd.org'],
            [7241,1,'dana.maiuro@millville.org'],
            [115,2,'danatorrente@gmail.com'],
            [95,1,'david.westawski@ww-p.org'],
            [96,1,'DavidLamkin@linwoodschools.org'],
            [97,1,'davidschwartzer@hvrsd.org'],
            [98,1,'DBlazier@delbarton.org'],
            [99,1,'delesky@nvnet.org'],
            [100,1,'dena.andrews@millville.old'],
            [101,2,'dena.andrews@millville.org'],
            [101,1,'denamandrews@gmail.com'],
            [102,2,'denisehuntsinger@gmail.com'],
            [7213,1,'derricom@evesham.k12.nj.us'],
            [343,2,'Devine90@gmail.com'],
            [102,1,'dhuntsinger@monroetwp.k12.nj.us'],
            [7241,2,'djmaiuro@gmail.com'],
            [103,1,'dking@summit.k12.nj.us'],
            [110,2,'dkregler@spboe.org'],
            [7239,2,'dlupchinsky@comcast.net'],
            [7239,1,'dlupchinsky@lindenwold.k12.nj.us'],
            [95,2,'dlwestawski@gmail.com'],
            [104,1,'dmateyka@westex.org'],
            [105,1,'dmay@burlington-nj.net'],
            [106,1,'dmusacchio@brrsd.k12.nj.us'],
            [7240,2,'docmaddison@hotmail.com'],
            [107,1,'docprins@optonline.net'],
            [108,2,'Dohenymi@comcast.net'],
            [108,1,'Dohenymi@winslow-schools.com'],
            [109,1,'donna.terry@millville.org'],
            [110,1,'donnakregler@gmail.com'],
            [104,2,'donnamateyka@gmail.com'],
            [111,1,'doug.heyburn@wmtps.org'],
            [112,2,'doug.radziewicz@gmail.com'],
            [111,2,'dougheyburn@yahoo.com'],
            [112,1,'dougradziewicz@dvrhs.k12.nj.us'],
            [7253,1,'dpruitt@lowertwpschools.com'],
            [113,1,'drusso@rtnj.org'],
            [114,1,'Dtaylor@nburlington.com'],
            [114,2,'Dtaylor86@comcast.net'],
            [105,2,'dtmproject@comcast.net'],
            [115,1,'dtorrente@mapleshade.org'],
            [116,1,'dtorrente@msemail.rem'],
            [117,1,'dunn@leoniaschools.org'],
            [425,2,'dvoight752@aol.com'],
            [118,1,'dvolpehines@gmail.com'],
            [119,1,'dweaver@mtschools.org'],
            [60,2,'dwyer214@optonline.net'],
            [120,1,'dzugale@bernardsboe.com'],
            [144,2,'eafencik@gmail.com'],
            [134,2,'eamesser1@comcast.net'],
            [121,1,'ebaptist@trschools.com'],
            [122,1,'econtrevo@gpsd.us'],
            [133,2,'edgarkmariano@gmail.com'],
            [7217,2,'Edoc24@gmail.com'],
            [7217,1,'Edougherty@monroetwp.k12.nj.us'],
            [7218,1,'edowns@camdencsn.org'],
            [7221,1,'eeller@vineland.org'],
            [7221,2,'eeller83@gmail.com'],
            [123,1,'egattsek@gmail.com'],
            [7227,1,'egoldberg@collsk12.org'],
            [124,1,'egross@frhsd.com'],
            [125,1,'egupta@delranschools.org'],
            [126,1,'ehollander@wall.k12.nj.us'],
            [128,2,'ejmus3@verizon.net'],
            [127,1,'ejoseph@woodburysch.com'],
            [128,1,'ejrobertson@jacksonsd.org'],
            [129,1,'ekirk@bordentown.k12.nj.us'],
            [130,1,'ekneuer@hazlet.org'],
            [131,2,'elena_wise@lyndhurst.k12.nj.us'],
            [131,1,'elenawise@lyndhurst.k12.nj.us'],
            [122,2,'elisacontrevo@gmail.com'],
            [126,2,'ellenhollander13@gmail.com'],
            [132,1,'elynch@veronaschools.org'],
            [7240,1,'emaddison@woodburysch.com'],
            [133,1,'emariano@pds.org'],
            [134,1,'emesser@pitman.k12.nj.us'],
            [136,2,'emily.amatulli@gmail.com'],
            [140,2,'emilyhsmith16@gmail.com'],
            [135,1,'emoore@centralregional.net'],
            [124,2,'epgmusic144@gmail.com'],
            [7249,2,'eredluin72@gmail.com'],
            [136,1,'ereitter@rih.org'],
            [289,2,'eric.mclaughlin27@gmail.com'],
            [137,1,'erika.krimm@shrsd.org'],
            [125,2,'eringupta@comcast.net'],
            [138,1,'eschaberg@rtnj.com'],
            [139,1,'eshea@veccnj.org'],
            [140,1,'esmith@frhsd.com'],
            [141,1,'ethoman@bergenfield.org'],
            [139,2,'evanvibes@hotmail.com'],
            [142,1,'eveyyee@gmail.com'],
            [49,2,'Fantini4@comcast.net'],
            [143,1,'FAppello@wtps.org'],
            [42,2,'Farmerbenita@aol.com'],
            [7197,1,'fbennett@gcsd.k12.nj.us'],
            [392,2,'feldrew@comcast.net'],
            [6926,1,'felicia.c.villa@gmail.com'],
            [144,1,'fencike@spprep.org'],
            [145,1,'fillmorejames@hotmail.com'],
            [40,2,'firesongwed@gmail.com'],
            [7197,2,'fletchbennett@gmail.com'],
            [8355,1,'florencelemeur@yahoo.fr'],
            [380,2,'flutermusic@gmail.com'],
            [146,1,'foglemad@eht.k12.nj.us'],
            [147,1,'fretze@ptbeach.com'],
            [6926,2,'fvilla@pointpleasant.k12.nj.us'],
            [148,1,'gcolman@veccnj.org'],
            [149,1,'giannuzzi@mtlaurelschools.org'],
            [150,1,'gigliotti.a@deptford.k12.nj.us'],
            [152,2,'ginakehl@gmail.com'],
            [186,2,'giresijo@gmail.com'],
            [151,1,'girls7mom@aol.com'],
            [152,1,'gkehl@lrhsd.org'],
            [153,1,'gmandescu@chclc.org'],
            [154,1,'gorman.p@woodstown.org'],
            [63,2,'graffc87@gmail.com'],
            [430,2,'graffw83@gmail.com'],
            [155,2,'GregGardner6@gmail.com'],
            [155,1,'Gregory.Gardner@camdencatholic.org'],
            [148,2,'Gretabc123@gmail.com'],
            [7258,1,'grubinstein@eccrsd.us'],
            [156,1,'guerrasm@eht.k12.nj.us'],
            [157,1,'gunther.k@woodstown.org'],
            [158,1,'haberin@pway.org'],
            [7231,2,'harmonlaura@mac.com'],
            [260,2,'harmony56@hotmail.com'],
            [159,1,'harrison@crhsd.org'],
            [160,1,'hbritez@hpreg.org'],
            [161,1,'hcoe@trschools.com'],
            [162,1,'Hcolton@hcrhs.org'],
            [151,2,'headlibrarian@njys.org'],
            [161,2,'heather.holt1@gmail.com'],
            [165,2,'heatherlockart@gmail.com'],
            [163,1,'hendersonj@krsd.org'],
            [8438,1,'heybenson@comcast.net'],
            [164,1,'Hknight@mtps.us'],
            [165,1,'hlockart@chclc.org'],
            [164,2,'Hopecknight@gmail.com'],
            [160,2,'hpchoir50@hotmail.com'],
            [162,2,'hsoprano1@hotmail.com'],
            [258,2,'hushiepie@verizon.net'],
            [246,2,'iamamaiden@hotmail.com'],
            [166,1,'info@edgartonacademy.com'],
            [167,1,'Isherwoodp@middletownk12.org'],
            [168,1,'isiafakas@sboe.org'],
            [176,2,'jac6454@aol.com'],
            [7238,2,'jaclyn.leone@gmail.com'],
            [169,1,'jallen@spfk12.org'],
            [7243,2,'jamie.lynn.mchale@gmail.com'],
            [198,2,'jamie.ocheske@gmail.com'],
            [175,2,'jamielbunce@gmail.com'],
            [170,1,'jamitimms@icloud.com'],
            [169,2,'janm.allen@yahoo.com'],
            [171,1,'jaslanian@hpregional.org'],
            [212,2,'jasonjstraub@gmail.com'],
            [7228,2,'jawhitely@yahoo.com'],
            [172,1,'JBARNES@WTPS.ORG'],
            [173,1,'JBITTNER@mahwah.k12.nj.us'],
            [7199,1,'jbradshaw@wdeptford.k12.nj.us'],
            [174,1,'jbrzozowski@westfieldnjk12.org'],
            [175,1,'jbunce@somsd.k12.nj.us'],
            [176,1,'jcann@delanco.com'],
            [177,1,'Jcantaffahhs@hotmail.com'],
            [178,1,'jchiara@gehrhsd.net'],
            [179,1,'jcrowley@brrsd.k12.nj.us'],
            [215,2,'jcurran@bernardsboe.com'],
            [170,2,'jdesiena@ebnet.org'],
            [185,2,'jdfoose@gmail.com'],
            [180,1,'jeffery.wilson@riverdell.org'],
            [181,1,'JEFFPANDO@paps.net'],
            [182,1,'jelefante@bhpsnj.org'],
            [183,1,'jennifer.moore@millvillenj.gov'],
            [219,2,'jenniferanneweir@gmail.com'],
            [7256,2,'jenrkvoice@gmail.com'],
            [184,1,'jesse.argenziano@wwprsd.org'],
            [185,1,'jessenje@cgschools.org'],
            [205,2,'jessicalynpomeroy@gmail.com'],
            [145,2,'jfillmore@hamilton.k12.nj.us'],
            [186,1,'jgiresi@fairlawnschools.org'],
            [187,1,'jgoodrich@gehrhsd.net'],
            [187,2,'jgoodrich824@gmail.com'],
            [7228,1,'jgreen@chartertech.org'],
            [7199,2,'jill@haddonfieldschoolofmusic.com'],
            [7237,2,'jjkrowe@msn.com'],
            [188,1,'JJohnson@monroetwp.k12.nj.us'],
            [213,2,'jjthomas05@icloud.com'],
            [189,1,'jkolody@bhprsd.org'],
            [190,1,'jkoryat@holmdelschools.org'],
            [7238,1,'jleone@riverside.k12.nj.us'],
            [191,1,'jlerch@collsk12.org'],
            [192,1,'jlobiondo@htps.us'],
            [193,1,'jlouie@fairlawnschools.org'],
            [194,1,'jlowe@delranschools.org'],
            [195,1,'jmark@chclc.org'],
            [7243,1,'jmchale@tkcs.org'],
            [196,1,'jmcmullin@collsk12.org'],
            [197,1,'jmoore@palmyra.k12.nj.us'],
            [197,2,'jmoore2830@gmail.com'],
            [198,1,'jocheske@mullicaschools.com'],
            [182,2,'joeelefante78@gmail.com'],
            [222,2,'Joezachowski@yahoo.com'],
            [199,1,'john.enz@ww-p.org'],
            [200,1,'Johnbaccaro@gmail.com'],
            [203,2,'johnperkis4565@msn.com'],
            [7234,1,'jon.holland@pilgrimacademy.org'],
            [94,2,'jonathan08062@yahoo.com'],
            [201,1,'joseph.fritz@wwrsd.org'],
            [202,1,'joseph_bongiovi@princetonk12.org'],
            [203,1,'jperkis@bhprsd.org'],
            [204,1,'Jpicone@flboe.com'],
            [204,2,'Jpicone1122@gmail.com'],
            [205,1,'jpomeroy@hackettstown.org'],
            [206,1,'jporco@gehrhsd.net'],
            [207,1,'jpuliafico@mail.ocvts.org'],
            [208,1,'jpwoodworth@gmail.com'],
            [209,1,'jreed@brigantineschools.org'],
            [7237,1,'jrowe@ocsdnj.org'],
            [210,1,'jsalzman@livingston.org'],
            [210,2,'jsalzman88@hotmail.com'],
            [189,2,'jskolody@aol.com'],
            [7191,1,'jstamper8@tdr.com'],
            [211,1,'jstanz@eccrsd.us'],
            [7263,1,'jstebich@cccharters.org'],
            [7263,2,'jstebich@yahoo.com'],
            [212,1,'jstraub@gatewayhs.com'],
            [213,1,'jthomas@ccts.net'],
            [214,1,'judithmorse@hvrsd.org'],
            [215,1,'jvc515@verizon.net'],
            [216,1,'jverderese@cboek12.org'],
            [7234,2,'jvholland25@yahoo.com'],
            [217,1,'jvonglahn@cboek12.org'],
            [217,2,'jvonglahn10@gmail.com'],
            [218,1,'jweingarten@srhsnj.com'],
            [218,2,'jweingarten625@gmail.com'],
            [219,1,'jweir@eustace.org'],
            [7273,1,'jwernega@quintonschool.info'],
            [220,1,'jwilson@brrsd.k12.nj.us'],
            [221,1,'jwinston@pingry.org'],
            [208,2,'jwoodworth@mtsd.us'],
            [222,1,'Jzachowski@wtps.org'],
            [223,1,'kadetskm@eht.k12.nj.us'],
            [157,2,'kahlilgunther@gmail.com'],
            [224,1,'kakinskas@eccrsd.us'],
            [352,2,'kanemusic@yahoo.com'],
            [225,1,'karenscott@popejohn.org'],
            [241,2,'kasonkjackson@yahoo.com'],
            [226,1,'kastere@middletownk12.org'],
            [228,2,'katharinebaer@gmail.com'],
            [7200,1,'kathryn.brown@pennsauken.net'],
            [7200,2,'kathryn.brown922@gmail.com'],
            [227,1,'kathryn.zintel@riverdell.org'],
            [7252,2,'kathrynpepesoprano@gmail.com'],
            [7236,2,'kauffmason@gmail.com'],
            [228,1,'kbaer@gpsd.us'],
            [229,1,'kbettys@brickschools.org'],
            [230,1,'kboehm@vtsd.com'],
            [230,2,'kboehm86@gmail.com'],
            [231,1,'kbryson@chatham-nj.org'],
            [232,1,'Kcoates@buena.k12.nj.us'],
            [233,1,'kconnolly@bhpsnj.org'],
            [234,1,'kcorbitt@wdeptford.k12.nj.us'],
            [235,1,'kcotter@marsd.org'],
            [236,1,'kcox@mrtes.com'],
            [237,1,'kdrachow@delranschools.org'],
            [237,2,'Kdrachowski@gmail.com'],
            [117,2,'kdunn21@verizon.net'],
            [7222,1,'kengelhart@runnemedeschools.org'],
            [238,1,'Kenneth.Brown@edison.k12.nj.us'],
            [244,2,'kershak3@gmail.com'],
            [239,1,'kgeronimo@ridgewood.k12.nj.us'],
            [240,1,'kgorz@aol.com'],
            [240,2,'kgorzynski@somervilleschools.org'],
            [252,2,'khteall@gmail.com'],
            [7222,2,'kj.engelhart@gmail.com'],
            [241,1,'kjackson@carteretschools.org'],
            [242,1,'kjohns@bridgeton.k12.nj.us'],
            [243,1,'kkahalehoe@mtsd.us'],
            [244,1,'kkershaw@wtps.org'],
            [245,1,'klittleton@buena.k12.nj.us'],
            [249,2,'kmarkowski105@gmail.com'],
            [232,2,'Kmcoates820@gmail.com'],
            [246,1,'kmeo@nhvweb.net'],
            [7256,1,'kmortka@bellmawrschools.org'],
            [7252,1,'kpepe@pgcpschools.org'],
            [247,1,'kpryor@rbrhs.org'],
            [248,1,'kraft.virginia@gmail.com'],
            [249,1,'kristen.markowski@montville.net'],
            [250,1,'kroeckle@lawrenceville.org'],
            [251,1,'ksarlo@keansburg.k12.nj.us'],
            [252,1,'kteall@mtlaurelschools.org'],
            [253,1,'ktmuka@pthsd.net'],
            [7274,1,'kwhitmore@etsdnj.us'],
            [254,1,'kzimmermann@hopatcongschools.org'],
            [255,1,'larrylittle03@gmail.com'],
            [256,2,'laspiano@hotmail.com'],
            [434,1,'latkins@prsdnj.org'],
            [256,1,'laura.lopez@sparta.org'],
            [7202,2,'laurencanna@gmail.com'],
            [257,1,'laynemm@comcast.net'],
            [258,1,'lcecil@medford.k12.nj.us'],
            [257,2,'lcochran@hammontonps.org'],
            [7209,1,'lcummines@vineland.org'],
            [259,1,'ldelfing@nburlington.com'],
            [146,2,'ldfog@comcast.net'],
            [7212,1,'ldorg59@yahoo.com'],
            [8416,1,'leann.hilton@yahoo.com'],
            [7225,1,'lfox@swsdk6.com'],
            [7225,2,'lgambino389@gmail.com'],
            [260,1,'lgerelli@monroetwp.k12.nj.us'],
            [7231,1,'lharmon@chclc.org'],
            [261,1,'libby.gopal@eastorange.k12.nj.us'],
            [261,2,'libbymontielgopal@gmail.com'],
            [272,2,'lilliannetorrente@gmail.com'],
            [262,2,'Linnell.Charles@yahoo.com'],
            [262,1,'LinnellC@kinnelon.org'],
            [263,1,'lisa.romero@woodbridge.k12.nj.us'],
            [7261,1,'lisa.simone23@gmail.com'],
            [263,2,'lisamichelleromero@gmail.com'],
            [270,2,'lisasab@optonline.net'],
            [264,1,'littlel@gtps.k12.nj.us'],
            [265,1,'LLausi@chclc.org'],
            [266,1,'lmorneweck@mahwah.k12.nj.us'],
            [267,1,'lneglia@gpsd.us'],
            [268,1,'lnewland@teaneckschools.org'],
            [275,2,'lnweisert@yahoo.com'],
            [72,2,'loefflermusic@hotmail.com'],
            [269,1,'louspi@bergen.org'],
            [270,1,'lrussoniello@wayneschools.com'],
            [271,1,'lsander@medford-lakes.k12.nj.us'],
            [7268,1,'LTest@monroetwp.k12.nj.us'],
            [272,1,'ltorrente@ranneyschool.org'],
            [273,1,'luthkec@eht.k12.nj.us'],
            [274,2,'lwardell@comcast.net'],
            [274,1,'lwardell@pv-eagles.org'],
            [275,1,'lweisert@manasquanboe.org'],
            [7259,2,'m.saul19@gmail.com'],
            [389,2,'maddi.schille@gmail.com'],
            [276,1,'magnus@cranfordschools.org'],
            [277,1,'makosj@eht.k12.nj.us'],
            [278,1,'malloyd@madisonnjps.org'],
            [279,1,'manderson@tenafly.k12.nj.us'],
            [7220,1,'marciadunlap1@yahoo.com'],
            [280,1,'mardrew1441@yahoo.com'],
            [281,1,'margolis.a@deptford.k12.nj.us'],
            [282,1,'marinelj@eht.k12.nj.us'],
            [7206,2,'marisamanion@gmail.com'],
            [283,1,'mark.bencivengo@ww-p.org'],
            [304,2,'maryfhuhmann@gmail.com'],
            [284,1,'Matthew.adams@millville.org'],
            [285,1,'matthew.lee@edison.k12.nj.us'],
            [326,2,'matthew.swiss@gmail.com'],
            [285,2,'matthewclee2012@gmail.com'],
            [321,2,'Maurasherlach@yahoo.com'],
            [7209,2,'mazuhascar@aol.com'],
            [286,1,'mcarrafiello@hammontonps.org'],
            [286,2,'mcarrafiello@me.com'],
            [287,1,'mchambers@hpschools.net'],
            [289,1,'mclaughline@ptbeach.com'],
            [290,1,'mcmahonst@clearviewregional.edu'],
            [291,1,'mcouden@sbpsnj.org'],
            [292,1,'mdigaetano@bloomfield.k12.nj.us'],
            [7215,1,'mdishong@medford.k12.nj.us'],
            [280,2,'mdrew@mountsaintmary.org'],
            [293,1,'MEBNER@WTPS.ORG'],
            [7213,2,'meganderrico@gmail.com'],
            [325,2,'megansuozzo@gmail.com'],
            [294,1,'melkin@pascack.org'],
            [307,2,'meltepp@yahoo.com'],
            [314,2,'Melynda.morrone@gmail.com'],
            [7223,1,'mernst@acboe.org'],
            [295,1,'meszarosj@nvnet.org'],
            [296,2,'mgasko@immaculatahighschool.org'],
            [296,1,'mgasko2@gmail.com'],
            [297,1,'mgilmartin@mka.org'],
            [298,1,'mgray@trschools.com'],
            [299,1,'mgreen@peddie.org'],
            [300,1,'mgriffin@monroe.k12.nj.us'],
            [7233,1,'mhoffman@pemb.org'],
            [292,2,'michelle.digaetano@gmail.com'],
            [301,1,'miclem@bergen.org'],
            [7244,2,'MillsTR1@gmail.com'],
            [267,2,'mimibella3200@gmail.com'],
            [7188,2,'Mistypenguins@gmail.com'],
            [302,1,'mjedwabnik@livingston.org'],
            [7236,1,'mkauffman@pennsauken.net'],
            [303,1,'mkeith@mtps.com'],
            [304,1,'MKenny@mail.ocvts.org'],
            [305,1,'mlapomardo@shrewsbury.k12.ma.us'],
            [306,1,'mlombarski@bhprsd.org'],
            [7233,2,'mlucarano@hotmail.com'],
            [307,1,'mmanzano@wdeptford.k12.nj.us'],
            [308,1,'mmazzoni@mullica.k12.nj.us'],
            [309,1,'mmccormick@holmdelschools.org'],
            [310,1,'mmcgrath@ncs-nj.org'],
            [311,1,'mmcguire@veronaschools.org'],
            [312,1,'mmgrondin@gmail.com'],
            [313,1,'mmjohnson@ltps.info'],
            [314,1,'Mmorrone@monroetwp.k12.nj.us'],
            [306,2,'mnlombarski@gmail.com'],
            [315,1,'monopchenko@abseconschools.org'],
            [316,1,'moorer@gtps.k12.nj.us'],
            [266,2,'mornefuld@gmail.com'],
            [317,1,'mpaglione@mtps.com'],
            [318,1,'mpaglione@mtps.us'],
            [319,1,'mpetrush@hcrhs.org'],
            [320,1,'Mr.wolf@hermits.com'],
            [34,2,'Mrbbacon@yahoo.com'],
            [7254,1,'mreilly@westamptonschools.org'],
            [7227,2,'MrEliGoldberg@gmail.com'],
            [318,2,'mrp125@comcast.net'],
            [137,2,'mrs.ekrimm@gmail.com'],
            [109,2,'mrsdonnaterry@gmail.com'],
            [7259,1,'msaul@dtschools.org'],
            [6924,1,'mschill@manasquan.k12.nj.us'],
            [6927,1,'mschille@manasquan.k12.nj.us'],
            [321,1,'Mschwartz@pinehillschools.org'],
            [322,1,'mstanard@mountlaurel.k12.nj.us'],
            [323,1,'mstephenson@flboe.com'],
            [324,1,'mstingle@wmrhsd.org'],
            [7265,1,'mstrong@mountlaurel.k12.nj.us'],
            [325,1,'msuozzo@pway.org'],
            [326,1,'mswiss@rtnj.org'],
            [327,1,'muhler@mhrd.org'],
            [328,1,'murray@salemnj.org'],
            [320,2,'mwolf1023@gmail.com'],
            [329,1,'mwooden@smlschool.org'],
            [330,1,'mzabiegala@mhrd.org'],
            [331,1,'mzoppina@psdnet.org'],
            [332,1,'nancybubeck@sccanj.org'],
            [342,2,'nawadley@gmail.com'],
            [332,2,'nbubeck@verizon.net'],
            [333,1,'nburke@mtps.com'],
            [54,2,'ncascione@paramus.k12.nj.us'],
            [334,1,'NCiminnisi@livingston.org'],
            [341,2,'ncsnod@aol.com'],
            [335,1,'ndickinson@wtps.org'],
            [336,1,'ndiyenno@medford-lakes.k12.nj.us'],
            [8407,1,'ngarciaa1221@gmail.com'],
            [337,1,'nhodge@rbrhs.org'],
            [7235,1,'nhourigan@trschools.com'],
            [338,1,'nmonte@nutleyschools.org'],
            [265,2,'notes2lausi@gmail.com'],
            [339,1,'nowmos.c@woodstown.org'],
            [340,1,'nrotindo@lrhsd.org'],
            [341,1,'nsnodgrass@lrhsd.org'],
            [342,1,'nwadley@mfriends.org'],
            [167,2,'Oboe32@aol.com'],
            [343,1,'Odunn@pitman.k12.nj.us'],
            [7271,2,'OffBrdStPlyrs@comcast.net'],
            [344,1,'oharat@ptbeach.com'],
            [310,2,'oscarpartyof3@verizon.net'],
            [345,1,'palmentieria@hamiltonschools.org'],
            [357,2,'pamela.turowski@gmail.com'],
            [346,1,'pastert@northernhighlands.org'],
            [27,2,'paynter@optonline.net'],
            [347,1,'pblanchard@rutherfordschools.org'],
            [348,1,'pdanner@wmrhsd.org'],
            [349,1,'Pdeal@monroetwp.k12.nj.us'],
            [350,1,'pessolano.a@woodstown.org'],
            [351,1,'pghachey@gmail.com'],
            [351,2,'phachey@roxbury.org'],
            [7270,2,'pianoman2468@yahoo.com'],
            [7202,1,'pitmanmusiclessons@gmail.com'],
            [352,1,'pkane@krhs.net'],
            [353,1,'PLA7074@hotmail.com'],
            [354,1,'pmccullen@whrhs.org'],
            [7246,1,'pmurray@childrensong.org'],
            [7312,1,'pmurray@haddonfield.k12.nj.us'],
            [347,2,'polivo214@hotmail.com'],
            [355,1,'potterl@eht.k12.nj.us'],
            [356,1,'pphillips@twpunionschools.org'],
            [7253,2,'pruittsings@gmail.com'],
            [39,2,'psunittany83@comcast.net'],
            [357,1,'pturowski@burlcoschools.org'],
            [7260,2,'rachelannsiegel@gmail.com'],
            [7262,2,'rachelflute@gmail.com'],
            [358,2,'raf.ajr@att.net'],
            [358,1,'rafaniello@cranfordschools.org'],
            [359,1,'randywhite@hvrsd.org'],
            [360,1,'rbaker@veccnj.org'],
            [362,2,'rburich@hotmail.com'],
            [361,1,'rcarlin@monroetwp.k12.nj.us'],
            [362,1,'rcoccia@wdeptford.k12.nj.us'],
            [363,1,'rdilauro@lrhsd.org'],
            [7214,1,'rdipilla@medford.k12.nj.us'],
            [364,2,'rdore@pascack.org'],
            [364,1,'rdore@spboe.org'],
            [377,2,'rebeccadpollock@gmail.com'],
            [328,2,'renmur7@yahoo.com'],
            [365,1,'rfastnacht@trschools.com'],
            [366,1,'rhorn@ucvts.org'],
            [367,1,'riccid@stratford.k12.nj.us'],
            [382,1,'Richard_tinsley1@yahoo.com'],
            [368,1,'rick@mfrholdings.com'],
            [369,1,'rjoubert@lrhsd.org'],
            [370,1,'rmcallen@frhsd.com'],
            [288,1,'rmcinnis@clearivewregional.edu'],
            [288,2,'rmcinnis22@gmail.com'],
            [371,1,'robert.peterson@ww-p.org'],
            [366,2,'robynleerhorn@gmail.com'],
            [372,1,'rodrigo.vega@millburn.org'],
            [373,1,'roeckd@eht.k12.nj.us'],
            [374,1,'rojekm12@gmail.com'],
            [166,2,'rolltop36@comcast.net'],
            [375,1,'rosenberg@leoniaschools.org'],
            [376,1,'roznup@comcast.net'],
            [377,1,'rpollock@lindenwold.k12.nj.us'],
            [368,2,'rretzko@hotmail.com'],
            [378,1,'rsaltzman@ramsey.k12.nj.us'],
            [379,1,'rshappell@burlington-nj.net'],
            [7260,1,'rsiegel@chclc.org'],
            [7262,1,'rsmith@medford.k12.nj.us'],
            [380,1,'rstitt@ims.k12.nj.us'],
            [381,1,'rswinney@audubonschools.org'],
            [7258,2,'rubijoy@aol.com'],
            [383,1,'rwalder@bordentown.k12.nj.us'],
            [294,2,'rxelk@yahoo.com'],
            [361,2,'ryanjcarlin@gmail.com'],
            [384,1,'ryoung@jacksonsd.org'],
            [402,2,'s.d.mccormack08@gmail.com'],
            [271,2,'sanderl@rider.edu'],
            [403,2,'sandymeltzer@gmail.com'],
            [385,1,'santillis@hamiltonschools.org'],
            [391,2,'saratdreher@gmail.com'],
            [386,1,'sbourque@ridgewood.k12.nj.us'],
            [387,1,'sburris@psdnet.org'],
            [388,1,'sbyrne@whschool.org'],
            [389,1,'schillema@winslow-schools.com'],
            [8418,1,'schmidty1965@gmail.com'],
            [404,2,'scmickle@yahoo.com'],
            [390,1,'sconners@frhsd.com'],
            [67,2,'scottce.cs@gmail.com'],
            [394,2,'scottpgarvin@gmail.com'],
            [405,2,'scottpieczara@gmail.com'],
            [391,1,'sdreher@lehsd.org'],
            [392,1,'seigela@hamiltonschools.org'],
            [393,1,'sfinnan@delranschools.org'],
            [7224,1,'sfisher@cychoirs.org'],
            [394,1,'sgarvin@claytonps.org'],
            [395,1,'sgraser@chclc.org'],
            [396,1,'SGREGOR@WTPS.ORG'],
            [327,2,'shelly101280@hotmail.com'],
            [397,1,'sidney7215@hotmail.com'],
            [7247,1,'siiyara.nelson@pennsauken.net'],
            [7247,2,'siiyaratnelson@gmail.com'],
            [129,2,'singdoremi@yahoo.com'],
            [429,2,'singer667285@gmail.com'],
            [378,2,'singingduck10@gmail.com'],
            [398,1,'sinigaglioa@krsd.org'],
            [7242,2,'siobhancmarr@gmail.com'],
            [393,2,'sjfinnan@yahoo.com'],
            [399,1,'sjohnston@woodburycityschools.us'],
            [400,1,'skirkland@npsdnj.org'],
            [399,2,'skjohnston2010@gmail.com'],
            [7242,1,'smarr@htsd.us'],
            [401,1,'smcanally@pingry.org'],
            [402,1,'smccormick@gcsd.k12.nj.us'],
            [403,1,'smeltzer@epsd.org'],
            [7276,1,'smetal@tdr.com'],
            [7189,1,'smetal8@tdr.com'],
            [404,1,'smickle@pitman.k12.nj.us'],
            [7251,1,'spearson@rcscherryhill.com'],
            [405,1,'spieczara@pittsgrove.net'],
            [406,1,'spowell@mtps.com'],
            [407,1,'srapp@summit.k12.nj.us'],
            [408,1,'ssmendel@earthlink.net'],
            [410,2,'sstofa@metboe.k12.nj.us'],
            [409,1,'sstyers@ims.k12.nj.us'],
            [410,1,'stefenystofa@yahoo.com'],
            [41,2,'stephberger811@gmail.com'],
            [411,1,'stkachenko@mtps.us'],
            [411,2,'stmadeinua@aol.com'],
            [7265,2,'strongfamily6@gmail.com'],
            [395,2,'summervoicecamp@gmail.com'],
            [412,1,'swaldron@lrhsd.org'],
            [7270,1,'sweber@mfriends.org'],
            [7248,2,'tallenolsen@gmail.com'],
            [7226,2,'tamahsue@me.com'],
            [413,1,'tbeadle@wmrhsd.org'],
            [414,1,'tbojanowski@pointpleasant.k12.nj.us'],
            [415,1,'tbourgault@brrsd.k12.nj.us'],
            [7201,2,'Tburdey@msn.com'],
            [7201,1,'Tburdey@smrschool.org'],
            [416,1,'tcapa@saddleriverday.org'],
            [417,1,'tcarroll@ims.k12.nj.us'],
            [6925,1,'tchristopher@ranneyschool.org'],
            [418,1,'tdaly@wdeptford.k12.nj.us'],
            [7257,2,'tdrosie@gmail.com'],
            [414,2,'tedaeo@optonline.net'],
            [7245,1,'terminnix@gmail.com'],
            [7226,1,'tfreni@gloucestertownshipschools.org'],
            [7273,2,'thelonearranger1@comcast.net'],
            [419,1,'Thenderson@lehsd.k12.nj.us'],
            [7232,1,'thengeli@pv-eagles.org'],
            [7232,2,'theresahooks@comcast.net'],
            [337,2,'thevocalfocus@gmail.com'],
            [7269,1,'Thomasc@rowan.edu'],
            [7624,1,'tinsleyr@eht.k12.nj.us'],
            [420,1,'tkernizan@oceanschools.org'],
            [7244,1,'tmills@haddonfield.k12.nj.us'],
            [7248,1,'tolsen@burltwpsch.org'],
            [346,2,'tpaster@optonline.net'],
            [421,1,'triccardi@hpregional.org'],
            [421,2,'triccardi214@gmail.com'],
            [9,2,'trishjoyce1@comcast.net'],
            [7257,1,'trosie@acseht.org'],
            [422,1,'tvoorhis@ridgefieldschools.com'],
            [7250,2,'ullaparmentier@gmail.com'],
            [7250,1,'uparmentier@mtlaurelschools.org'],
            [7230,2,'valhamburg28@gmail.com'],
            [7219,1,'vdubeau@delsearegional.us'],
            [372,2,'vegarj81@gmail.com'],
            [7230,1,'vhamburg@abseconschools.org'],
            [423,2,'virajlal@gmail.com'],
            [248,2,'virginia.kraft@sbschools.org'],
            [7218,2,'visgod1@aol.com'],
            [426,2,'vivian.perng@gmail.com'],
            [423,1,'vlal@newarka.edu'],
            [424,1,'vmoreno@nbtschools.org'],
            [424,2,'vmoreno0903@gmail.com'],
            [425,1,'voightl@warrenhills.org'],
            [422,2,'voorhisong@aol.com'],
            [426,1,'vperng@ucvts.org'],
            [427,1,'walkerc@hhsd.k12.nj.us'],
            [7271,1,'walter.webster@commercialschools.org'],
            [428,2,'weatherbymn@gmail.com'],
            [428,1,'weatherm@eht.k12.nj.us'],
            [429,1,'weikel.h@deptfordschools.org'],
            [430,1,'wgraff@monroetwp.k12.nj.us'],
            [431,1,'wilcox@nvnet.org'],
            [220,2,'wilsonjohn.iii@gmail.com'],
            [78,2,'wjconnjr@gmail.com'],
            [432,1,'wolffm@ufrsd.net'],
            [7264,2,'WsSongster@aol.com'],
            [7264,1,'wstrouse@trschools.com'],
            [433,1,'wyerkes@wdeptford.k12.nj.us'],
            [227,2,'zintelks@gmail.com'],

        ];
    }
}
