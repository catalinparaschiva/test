<?php

class WI_Subscriber_Service_Validation
{

    public $list_id;
    public $has_callback;
    protected $not_allowed_to_use_select = array(4527,4491,4217,5084,4528,4529);

    public function __construct($request) {
        $this->request = $request;
    }


    public function validateListId() {
        if (empty($this->request['list_id'])) {
            throw(new Exception('Required parameter [list_id] is missing!'));
        }

        $this->list_id = (int) $this->request['list_id'];
    }


    public function validateServiceKey() {
        if (empty($this->request['service_key'])) {
            throw(new Exception('Required parameter [service_key] is missing!'));
        }        
        /*
        if (md5($this->request['service_key'] . '|' . $this->list_id) != $this->getHashByListId()) {
           throw(new Exception('Service Key mismatch!'));
        }         
        */       
    }


    private function getHashByListId() {
        $config = array(
                        2009 => 'c3a4945b38f256dc780310b16ee46700', // noriel
                        2910 => '7c5fe89a5906b5f45015a683371e4639', // 7c5fe89a5906b5f45015a683371e4639 = md5(service_key|list_id), service_key (uneori poate fi synk_key din db) nu este stocat nicaieri, se trimite doar clientului
                        3029 => '99303a62107348e4ecfcd08125d56afc', // dpap
                        3966 => '9c0ff338b5ce96152e9ebbf43b18395e', // dpap lista comenzi
                        3804 => '39e24b11738db7d87e023180b899c4e6',
                        3666 => '871dd7e5bea9f1ee02037f1da67a07e3',
                        3827 => '1583c234cac23335112ace2289182a2b',
                        3449 => '16ffdd726f6a39139916830fe8b6fde1',
                        3854 => '8bc38f8d9bf1cf678bf3fb03896a3300',
                        3857 => 'c8b1d3bade734c6a6a5cc955cfc2bed2',
                        3859 => '437d7e22933ea93231548f898aacd6b8',
                        3865 => '5fc513c3c7e59b54adcc714f4a9533dc', //noriel teste
                        3866 => 'dbd94ab7c0bf54dc91598e922ea489a2', //noriel teste
                        3871 => '358c15f4f7809ec5779e5a2782824329',
                        3907 => '9da303aa51c6b284edb856cca2f73cc1', //b-mall
                        3964 => '0e9c8cac9d8a855747c629a536079fb0', //ING LP savings
                        3975 => '57b9b22ce5e6b37a2d94fa5dcfd8525f', //ING LP savings
                        3987 => '4e8d3c3b797d8c3d1c328373a8647ebe', //ING LP savings
                        3989 => '5230b46b4303183f57982452d9f423f5', //ING
                        3979 => '618e86f43e96f8fb8756018326bc91ac', //noriel teste
                        3684 => '30ac63b06db96e010eae09d1ffb82759', //horeca.mobexpert.ro
                        4344 => 'f89d2e39133bf18dafd28a84ad7970fe', //horeca.mobexpert.ro
                        4084 => 'b7053f6a5ced8b3e6d1876ed83f7b759', //otter comenzi
                        4067 => '28d9515f7b78341a5d053394449b0dde', //aldo
                        4166 => 'aa2ed4aef672482554a27cacafc59578', //aldo comenzi
                        3275 => '5c98d76d38a41e50cb0bd48759a524f3', //bkids comenzi
                        3427 => 'f98b9ebc95a40693e431cd647100c9bf', //bkids
                        4131 => 'a1e3bb82a6cca875986da27b98cc569a', //bkids comenzi
                        4217 => '97a337ab9d51e4b22be2031e98f59bfe', //seniorprogramming.ro | # ING BANK
                        4255 => 'b13c692e0b70d9546128863760d40c34',
                        4115 => '36d3a914755fac435c49505aa71f7a96',
                        3974 => '90b4eb099732fa89183da236c6b8894d', //Mobexpert Retail
                        4287 => '6bc242feca1d5911c6512e8fee82a3f3', //SME
                        4326 => '357076ebbf4ebcc7bed34810e9593160', //Edenred
                        4327 => '6f8752085f73983e58220cb1e94b0cf5', //Edenred
                        4328 => '2bd2b0869b6f2bc493666870227750d4', //Edenred
                        4329 => 'bfd5acb09f14a72004ab3cbddca87d79', //Edenred
                        4330 => '0b7ba58f3beae289cc04174126674971', //Edenred
                        4331 => '335aa7848c30e7a9397f7de184ab54c4', //Edenred
                        4332 => 'ad0bcea34f3a0442446e5e22febf9f00', //Edenred
                        422  => '09d9eda1725c36eaff2f033d4b0de615', //EdenredRomania
                        4371 => 'eae7144a95a08b398407f94f0525e20c', //Ing Bank
                        4391 => '93bf6bcf365f904bb9e22ccbbf8a5688', //Ing Bank test
                        4441 => '69f09af3f977883d2c9057a0aca3506e', //Nestle
                        4447 => 'b36e0a9546520a79c0435595bdbf0dbb', //Noriel
                        4474 => '49fa158222110f3fcb572446d4daa5b7', //NN Asigurari
                        4465 => '48d0cc16cea6ee0a21817c6e40b34b16', //ING BANK
                        1235 => 'e63e4b11cf8208950b8aa34c123bde3f', //ING BANK
                        4481 => '4b79a77e0c0d8c69d7856226d65d5701', //ING BANK
                        1606 => 'ee22f5c5789209552902c54aa54387aa', //ING BANK
                        4491 => '63a6044d27e215132f4ed4037704997b', //ING BANK
                        4492 => '39762ef13238d6e7c2e31b84e9490e88', //ING BANK
                        4496 => '32b611001618a8b07fe8655ffb3658f1', //mobexpert
                        4531 => '94a84388cd7a40e3b07e529b7100f1eb', //oriunde happytour
                        4527 => 'ece72f51ca531fe0b447f4f6d2f74ca7',
                        4042 => '3fcf96d3f9a1e6ec6d827957c12d0d99', //OTTER
                        4528 => 'fa75fb34a049cbec0a99b7650db190b4',
                        1655 => '7bd1c7bdb34db45223a1491334d21e0a', //happy-tour abonare
                        4577 => '6aeb4f33e030ba3504f4d9bed4d26ca0', //melkior md
                        4565 => '7b0ad84a3dbaf4eab75ead889743a33d', //maksense
                        4602 => '8a50199459e352607974b1c7b1f5a858', //ING_BANK
                        4931 => '1e77eb7f7ab0a6860bb2fc29f2365941', //ING BANK
                        4605 => '4f55eb29b12f8c808585a8cc370c5907', // happy tour
                        4539 => '2bc7a9d4dbf3c50089ff434e96a4468a', // continentalhotels
                        4613 => '752d864a78fa26758392ab4632ece3f4', //mobexpert
                        4606 => 'fea1da4f6595b2b88a634ff1e0eb84ff', // republica
                        4623 => 'dd7544d65c4d64857d1a9fe230c2cbf6', // republica
                        4625 => '65e417ea279248063ed09321e7a96bae', // gratiela grapefruit
                        4628 => '24f9396c11550f43ca901e9a6078886c', // gratiela grapefruit cristina raducu
                        4633 => 'ef0a121da754045b02c28a6eec0ce9d1', //gratiela grapefruit
                        4654 => '4d660ea36aa4dd68fbd409cedf23973e', //tezyo.com
                        4600 => 'cdb75757fb34681aa6a191de12d2a508', // romstal lista comenzi
                        4659 => '3fad3d68eeab47142dcf961de02ace16', //dent distribution
                        4671 => 'be7d33fec9b0baa94adc53065062861b', // ing_bank
                        4250 => '6736d62ab9d97fad88ded0f34e779bca', //flanco flamingo
                        1955 => 'e6a6f349b0f47447a03f0399b5434d45' , //flanco all
                        4707 => 'a608869cbfb7798587fcd46c5b69911e', //ing_bank
                        4738 => '24ce1b234e2c2ae64d18e66894ef4719', //ing bank
                        4777 => '5fe52bc9fc4902a4341f274df9006345', //ing_bank
                        4784 => '9708449beb251858817abd7c458d1778', // vpc ing contractuale
                        4785 => 'f8717d7ea05481a26c93b2ceddf76d8a', // vpm ing contractuale
                        4786 => '733f207c78d99c61377f9134c84fc422', // vpo ing contractuale
                        4813 => '0d3757c104678d4d1693ecd8a29f8380' , //Noriel bebe scutece
                        4814 => 'f8860329bc6238906fd11113304fb1b8' , //NORIEL BEBE scutece teste
                        4819 => '45efce972e058e34868bab0a5951958f' , // ing_bank
                        4821 => 'b38ba67505a4eafa3e68bb375f66f729' , // noriel
                        4826 => 'b3908f548e8b938cee996c57c0624ea7' , // edenred sftp
                        2060 => 'c3d6d0488d30c737db20eabf183d56c9', // kitchen shop
                        4831 => 'ce1f37c9bcdad86e0fd199cb0bde89ce',  // staratrium
                        4851 => 'a76b1b12543f27eaa7c654f8265a098d', // dacia
                        4892 => '8f299671ff5f398f78c728442c04aba6',
                        1928 => 'f3565a5c23c33c0b59546bfa9eef8c70', // Paravion
                        1977 => 'a97d34ea16c92948b895a165cd65a4d2',
                        3741 => '4d97047785e91f93919523d44a9b9788',
                        4010 => 'a308ed127e86984446d16a2681794fbc',
                        4859 => 'c22252aadc6ae0da26089b9870d76612', #sole_bc
                        3617 => '03aaca41623a89898d474b89ae69e481', #quick_mobile
                        4455 => '5c064e4e4b82603f15972d48023f6ac0', #sprijina
                        4947 => '4b89ae09495844632735eac71b7a0285', #ing_bank 28.10.2016
                        4962 => 'cf70089338a7f2d4f31eaa6dc56fc795', # HITMAIL_TEST
                        4965 => '0527574307b5911fe9d18d7341373fbe',
                        4966 => '75d3426a820dfa67d507c81acf5118d9',
                        4967 => '65cb30818275801a5d3e19ae3526aaeb',
                        4968 => 'c685faa91c09b9d125c544ff73856297',
                        4969 => '83f1d84402e2de1466910a5529a65571', # HITMAIL PMORRIS 9+ TEMPLATES
                        4970 => 'af0cc7653a82dad20108487c5e8e4659',
                        4971 => '45e34ccfefb0adcc99bc8f0d0466760d',
                        4972 => 'e8fdff1918bc4a25c18a22f774a9582c',
                        5000 => '0c35604b8658e3ff6b1d16e072203139',
                        5007 => '20824f909929344f425b415e68d2e41c', # Nestle trimite-un-gand
                        1184 => '23397ebe146e9ed778123fbda03272b7', # PIA Audi
                        5009 => '5b7ab1aa77e5f9ca24dfa05b208ec648', # IQOS Capacel
                        5011 => '8d5aae1ad2941de3f58f7cc7bef47bb3', # PIA
                        5028 => '957b9d70e3251488cd84cb2a12fec806', # ING
                        5027 => 'fd8d23d259ccb91c5f53541f744dfeb3',  #NN WS PDF-uri
                        5034 => '3de71c0694a8e99e4abbccb25f4042d1', #ING CARDURI CGC
                        5026 => 'd6318d4d53058f0d5ad52608653a67a9',
                        1392 => '67f864204773328115303266b4d7bbf8', #Vola
                        5052 => 'a3c387f908f0aafcb8f2a9f3ed9d5da2', # makechange.ro 
			5054 => '9bd4f6f577f4585f0ea58b9f46e1f408', #ING
                        5041 => 'd67d06e5328f5e9b4675e0a994b93780', # Teste
                        5072 => 'b39bc7b45a4bf36566d55f824c1c0876', # piustyle - lista all
                        5080 => 'dfc830d4bd76544b65eefd25e76922f9', # Pro Plab Puppy Nestle
                        5084 => 'af6355eb46f9541147b30700bc6b6761', #ing_bank
                        5088 => 'cc3b9058cbc108e426e9bc3d4d2b886d', #ing_bank
                        5091 => 'e134553bd7030dce6b03dd82fb5ef9d9', // Castica cu Lion
                        5090 => '61f0b8467597eac46a3de54e18d79a50', // Purina Gourmet
                        5092 => '3124a7a81cd892f75c6bcbd7e29f44ef', // Promotie MAGGI
                        5095 => 'b35a04a29f0c25d4bc1f0ed1509a8a5d', #ING BANK credit personal
                        4829 => '3ee0e4781a7418aaae11315392b51a54',
                        5047 => '5b9d3a139e831f2c8b90a95b56b9b917', #persons.com.ro
                        5125 => 'ea950abc9c3f6ce2453f886599354a51', #ING
                        5113 => '253bf2ded11d46c63bd5e2ecc720a4e1', // Paravion
			5132 => 'af6b19a26d5158bea994594743df68fe', // ING
                        5139 => 'fafda71ce11aebc07b72865f30e06335',
                        5140 => 'f7cbba7f2488c55543d2005c2366864d',
                        5141 => '8987321753606ff557defe7619218db7', // IQOS
                        5142 => 'afb6e36458a55b050003b6a83b595780',
                        5143 => '8c873c96a1692c51ba4f25ec403a1a07',
                        5145 => '6742780b9119ec51bed4cfd0de4d73e3', // AUTOVIT
                        4609 => '320f620514a2b29e59a13f516c79a1a1', // TEZYO
                        5149 => '154940ac6415bf8345b333b1436222c7',
                        5150 => '936bfe53a663042b87125c706ae5d2f3',
                        5151 => 'f3124060aa7097944e3f39a339b748cf', // IQOS
                        5153 => '015beb1e0d31e710bc0c7a3895cd9d21',
                        5154 => '582b339b8d621da369eb91cbc568a028',
                        5156 => 'a2f8a064789c7f57bafdac3021649d04', // ING
                        5157 => '767bbe9f48a20cb7acdde1d572a6c72c', // ING
                        5158 => '079c2400a7824e56a6a47dc994d315a2',  // ING
                        5160 => 'b9365f183c1b8a7aa719402a2c06a9c3',   // OTTER
                        5161 => '460f9aaeeafb8109ae55b3f7e9a45e3d',
                        5018 => 'b1183e72a6fe960efa9a08f837a2c4ce', //ING
                        5152 => 'f8c8ab0cbf48e185195a328323ceb7d2', // Teste Mrpich
                        5167 => 'e4b4808498c212d89666719a1f00b99f', // Mobexpert
                        5144 => '64d9703232665f85ed1e04c1f9265aeb', // Paravion
                        5203 => '6bd84123103573d59a02b15a1bd9a3d9', // MRPICH RO SALES
                        5205 => '2c9018c0c9150df695f1949897fcc439', // MRPICH EN SALES
                        5207 => '130ebc1d680a5f43429ed53aa0ba1e84',  // Paravion
                        5213 => 'c09c6705806cb96a8f6c89768ab75b36',
                        5215 => '7036d55acfe0b4eab7887c2d5970e355', // Tezyo lista comenzi
                        5070 => '21fcaec0886061b2bc4f789732830715', // Salamander
                        5216 => '0ebaf8f5a68b94662d329c609f2e4aa3', // Salamander lista comenzi
                        5219 => '1537ce26cfdf9b3dab3b07a6b1451aa3', // ING
                        5220 => 'ee4417d1da8eaf1493ab6726b887e5db',
                        5201 => '3e23c2cad80a1e92163cb9f8e8bf3a22', // MRPICH RO NEWS
                        5202 => '8f49f4d8731d1667a92e669ecaa02033',  // MRPICH EN NEWS
                        4529 => '6354ada9db0eebfc917d8e117cf9a921',
                        4816 => '57ce1a0976e2c584a9b23f9ed33b6e7e',
                        5223 => 'd5e112f6cecba15f8dd1f19061814af6', // Nirvana (Nestle)
                        5232 => '222cd321dc7313d67605b50eb9c33063', // Purina Adventuros 2017 (Nestle)
                        5234 => '6778c172ee69fc326311174f8a941cf2',
                        5241 => 'c681abee64a7f70b87eddc903e604249', // IQOS
                        5245 => '4b0981d46369ef0639390e2883f8e52d',
                        5246 => 'c9f75f87d8cf26b068c392c586402367',
                        5247 => '9939cd72bc5ed9d36143c47962659b87',  // ALL IQOS :)
                        5248 => 'f19ae8483710754fcd60fa0b887e0082',
                        5249 => 'b31906bfa8564ca960da9d303a055116',
                        5250 => 'ea36c50069a5ba51e8713c940b21b30a',
                        5260 => 'a4dd753e9cf9b755c2c4e764a2602dcb',
                        5266 => 'cc1b5e835676a70fc996b9dd311c2abb', // IQOS AGAIN :D
                        5268 => 'd0903287c6083ce6c477947581f521d9',
                        5269 => '4be97a5bafb899253735a7a3ec6c7854',
                        4118 => '01db8d1ade5ae32ba4aa942cbd7835e7',
                        5276 => '51d7e8262d793e5504e7bd2235e67aca',
                        5281 => '7b1804614e0569a3e4f7424c45b1fb68', // IQOS
                        2948 => 'a168efdc6910bf6acc195e195e753a06',  // Autovit Total
                        5291 => 'c92313fedacaa1836ce00743fceb6e4f', // SAMSUNG
                        4744 => '68765274a2b55c629a8819bd52241d07',  // SAMSUNG
                        5290 => 'c93894c296d3819513bd3fc5ca60048c',
                        5297 => 'd58cfc41d1a627099deb423d006e4fd0', // ING 
                        2764 => 'ab07b25e087af8b8ea14b4f2d8b04038', // interauto
                        5302 => 'fb5711e6cbcb8239e1e58fb6c9de7e7c', // NESTLE UNTOLD 2017
                        5304 => 'fd869e273bf959fd109ff0a1f161bd0f', // ING
                        5308 => '10361d68b51446926444897fc30152ab',
                        5342 => '51524626af4e765a3b701abfb511c2c9', // IQOS TELCOR
                        5351 => '4a13c098e6c023e977a2fd4fabd61dc3',
                        5360 => '883b85e0532f46e44d2bcfa5999eead5', // ING
                        5366 => '8220c003f36f660695dbfa28d56e70b1', // Orhideea
                        5364 => '803575510701c511ae363b9107ea8b67', // lensa
                        5380 => 'dd9580dd1cdb9928ea9badc1edb0e31e', // Electronica_Azi
                        5383 => '575e7fba86ffcd4c3a76b917b7b58e0b', // ING
                        5384 => '767875d48cff5aa47bd3e061400c8d96', // ING
                        5379 => 'ed829f3e6b9bccdaf02437ea55d04f78', // ING
                        5386 => 'cf00a1bb167918c68f4200a95374ec23', // NN Campanie P3 2017
                        5387 => '6bef307a0092cfbd4c36905a232b52ec', // NN Campanie P3 2017
                        5388 => 'c61a83574f3f2722150772d95196f71e', // NN Campanie P3 2017
                        5393 => 'f579f3a14501d5ffb0e98049bfd0e480', // NN Campanie P3 2017
                        5392 => 'da3516aad9c30b1e52906e173779c4c3',
                        5401 => '077a7d162fc531aebcb85908a6a67461', // NN Campanie P3 2017
                        5407 => '541e6eb30fb0620412144fe94350b36f',
                        5417 => '8a3d30371c97920b042e3e19c81de985', // TELCOR
                        5423 => 'aa7725fe24b152d65aa8d0cf254efdcf',
                        5406 => '4e87e463c05e5834e8ee83e7a273de6c', // Melkior sales
                        5427 => 'ed668dbc4ba56cd4c3fa8471298c8f33',
                        5431 => '7ba30bfdb9992bf452247e119d103d58',
                        5434 => '59979cc2f051565f2b70d33949fb6524',
                        834  => 'eb36260496b60b5b1d9dbbec0ddab937', // Retargetare lead-uri NN
                        5435 => '7dff30d16f8c8ef31d5f7f27965bf6de', // ING News noiembrie 2017
                        5437 => 'b4584e7449737837df436f39c57ef183', // ING Modificari pachete
                        2909 => '9934737753337c929121192f421ea859', // Retargetare lead-uri NN
                        5445 => '66c2f1f7035a0f51ed75579d01bde8ac',
                        5428 => 'b8d648a8a3bae9c86af22fa9bf000e54',
                        5465 => '15b8407d2db0a50e635e930934824362',
                        5467 => '12e8d55b339fd435e035c3603f70f44f',
                        5468 => '7431b7b3fc655305ce68be4be3ffb1a4',
                        5469 => '97f365e3c71ba6ed60365b90b64845e2',
                        5476 => '95cf41f94c735d33e5cfa49eda2d22f3',
                        5494 => '295a1dcc51f823eb3e4e1ec81bac750f', // Nestle - Puppy
                        5473 => 'b072cfc9bdefdc8a8c0a56f3abe3fb2e', // Nicoro
                        5504 => '1a35022fe699d2311f7e7609e94e6d3a', // printcenter.ro
                        5361 => 'e0b03bce0035aa57d70ccbd668563ca9', // Chestionar NASS1
                        5523 => '3fafbd968eafafe1926de158bfd7539f', // Lion 2018
                        5525 => '75d2291e9db6f889c2b87092fc97885d', // Vizualizare raspunsuri chestionar
                        5555 => '1ac2bc770d09e1f505313ac047fe2605', // Confirmare invitatie Thailanda
                        5544 => '9c6b99b3b2e60d868d9a9cf1402073ab', // test magento
                        5545 => '70c46a380203bfa12abc2ce960e85167', // test magento sales
                        5495 => '6756ba0697f53be2cb8668bc230fe3ad', // Zaza
                        5301 => 'ef0801d0ac30590b2e95fa9f36fb4199', // Mattca
                        5509 => 'be7f8ad0064caec58ef8465b0949d143', // Nicoro vanzari
                        5253 => '06914d5ba1c0b8f99b8c6d1577f3d6aa', // OPO Renault 
                        5565 => '01b84a54f570f98becfa9537608381c0', // Edenred Moldova
                        5571 => '98a05f74b74d74579284a64c89fecc7c', // Nescafe 2018
                        5572 => '4c7d50e0ef9316fbcda4e42030a5afa0', // ECONTR_TR
                        5573 => '688c51440839df10fb3f74422b09a67f', // ECONTR_TRC
                        5574 => '93d86764ce98d9a61636975b3cf5c7ee', // ECONTR_TC
                        5575 => '90892521ef523e77beee8ea384783541', // ECONTR_TV
                        5576 => '9c7e888a8662a676cd53ff9013f0ebd1', // ECONTR_TVC
                        5585 => '2e0166c55f24607a270abe306f4bdd8e',
                        3948 => '27602e0abfc652cf2206e190518ff94f',
                        5583 => 'd4827181a45c4556c7bd464fa3b2c8cd',
                        4773 => 'f38493c259d363d1233a6c0902081cae',// Mattca
                        5577 => '17123b1982ec1a7564977e109bd79785',// PatriaBank
                        5581 => '4bdb1f043a2f448805455379efa4386a',// PatriaBank
                        5582 => 'c437f1676d90daf73646f3b45e17e513',// PatriaBank
                        5578 => '5b314f20639b35263824fa9fd0e79915',// PatriaBank
                        5579 => 'f257b1455f485d4b83063f50b04e4ba3',// PatriaBank
                        5580 => '8a062461be09325c495367a38c988551',// PatriaBank
                        5586 => 'd6c982b993b7f44d2d9b54bb26a60e04',// IQOS_CHESTIONAR
                        5591 => '288690d2640c936903abb243439781ef',// PIA
                        5596 => '9204d5d332685fbc1c19c28ebfe4ea7c',// facturi legrand concurs
                        5598 => 'aa8b1198f86e71ff6265b20c3600463f',
                        5588 => '23cdf38ec5dd1189233a2ff88c62e178',//LP Legrand Consolight & friends
                        5593 => '8fb403d8479d921847b7306d8ac652cc',//LP Legrand Arc Electronic & friends
                        5594 => '021fceb2d4443b9854b2dddf8260fdc8',//LP Legrand Promelek XXI & friends
                        5600 => 'daa2c10f7b642aab999d9f6e4cba4ad7',//Autentificare vizualizare LP
                        5602 => '59b2ff698da528b465584a08d4b77676',//Castigi cu Legrand revanzatori - Welcome
                        5603 => '3cafd335f8b1513071adb178003214d9',//Castigi cu Legrand revanzatori – Resetare parola
                        5168 => '08e2a992dfe81d6cd7c48a6da342ba33',//PET Dacia aprilie 2017
                        5607 => 'eed1b323510a19a9a38e0435f6597f91',//ING Tech
                        3995 => '59c4053d5f17b6c64aa8d1b4843fdd3c',
                        5609 => '7a3a2d835a3775c2a6780c9f2593a3a0',
                        5159 => '2cb64045025cc66d0d456af20e319c94',//PET Renault aprilie 2018
                        5611 => '6842a190ac0d00e39d6872553814b331',//PET Renault aprilie 2018
                        5613 => '7360b5b4cff5600e5908045cdf3be15b',//LP Legrand Euro Vial Lighting & friends
                        5615 => 'aa4709096a8a910265a42215600f72fe',//PatriaBank - WLC_1.1_Broker
                        5616 => 'f271583ebb2569db0a24ec54a9a2b97e',//Info Trip Marea Adriatica
                        5601 => '95f753a2188395bad4645424ed534a0f',//Netlinx - teste
                        5620 => '904cb9e640d589333a0154c63946a036',//NNDKP GDPR ro
                        5621 => '083cc75fd9acdefda12df8744c390681',//NNDKP GDPR en
                        5625 => '00c3878d4a52c66688b795bb874d908c',//Facturi Legrand concurs electricieni
                        5628 => 'b314c3c322c9c1a460545239928a2ab1',//Contracte Edenred
                        5262 => '00fc0af0c6105db227a4985c35072d25',//Legrand Ro
                        5630 => 'c0965adbd9056f9e8a208e3bdbaceb2c',//Feedback Consolight 
                        5636 => '35ec58540bd93c1d6e84f39cf2c4527c',//Zilele Legrand Brasov
                        5637 => '5cd058ebc4c35ffb83b4ae39cc28d136',//Zilele Legrand Bucuresti
                        5643 => '237fdb19bc4b2f516e716a96a15723aa',//Zilele Legrand Cluj
                        5640 => '18f6b6c351c0f70c60ca1efeb69e97bd',//Edenred sftp 4 - eximtur
                        5649 => '8e0fa6f6861ebe70176aa0b0c7ec67b3',//Chestionar cos abandonat
                        5655 => '860c6f23cce3c7671cc78d8aff87586d',//Happy Tour 2018
                        5049 => 'd17c853dd87978069706fce7a000f976',//Baza Mare Avia
                        5657 => 'dee5e13503ede9f0b9cc6b9148fe2724',//Aviamotors 2018
                        1879 => '47e0b0d7fe2d53762c995ca4d5c82618', //adaugat de nlx bogdan
                        5662 => 'ae1a59751d3c33ebeb32ee2060260c87', //adaugat de nlx bogdan
                        5667 => '5417bc5de44034ca8b4d9a440d4cb3fc', //adaugat de nlx bogdan
                        2658 => '3a10e8892f3a910d745677ab3da79c11', //adaugat de nlx bogdan
                        5670 => 'd408d5426e1e42ac3d8c7dd2d685795f', //adaugat de nlx bogdan
                        5672 => 'fee109fb3e38b008345a59325760e674', //adaugat de nlx bogdan
			5680 => '72d4a1487388953c04aafa9089f4457d', //adaugat de nlx cristi
			5681 => '57f36188141f027a41280790cc7e5ca0', //adaugat cd nlx cristi
                        589  => '526215b74119959d3c1f68e71bd45d6a',
                        5686 => '288bc563b93d200c95ab30d1d513a69e',
                        1268 => 'cc0839054fc9386eea60fb310be3d52d',
                        5687 => '860515ceb3c943b1e38375977cb023c0',
                        497  => 'dbfb9a2a30754f6f73ea944a497cb459',
                        5685 => 'ad93108b89fa57e3fe8abc73c509f215',
                        499  => 'ceaaa0f3579ad241ead65a1bcd6fea0b',
                        5688 => '752c507afb491da4b2d9c032825f88a6',
                        5693 => '6E5CC425209DEB19EAB7BD1B3F5AE157',
                        2329 => '5F602B140A7BAE182F56ACB965528237',
                        1450 => 'df8aa5c42582fbce17c34fc2f465c206',
                        5682 => '5A9F3C23D11395C3B00160BC1A10AEA7',
                        3174 => '641194E3300C827ACF3925A1EA2E2F91',
                        5683 => '24CE04F6BB0428783235FCD1F4A217BC',
                        4557 => 'A58523F8D19CA7F3A095A0E214C0F4F3',
                        5684 => '403132609E2FFEF4263541FD17D07387',
                        533  => 'C25D306DCE84502553BCE61311A41103', //nu merge
                        5692 => 'DDA759D3D807C60F9D62A7301F27BF32',
                        5691 => '748557DB3F23AFC98D1472C3CFF98206',
                        5690 => '4AA3BA128E52F4BD38A2947BF9522407',
			2180 => 'a102586e6ae914c86930f5a112348ca3', //nlx cristi
			4773 => 'f38493c259d363d1233a6c0902081cae', //nlx cristi
			5709 => '189680313ce584b3ffcd57f03ad99e03', //nlx cristi
			5710 => '54b1b3e189b246cb08111f9e0ee692f8', //nlx cristi
                        5713 => '46E3070C1E8DC558B40C9FE8A893D61B',
                        5714 => 'C3A6CA378E4DDF4AB9F147D911AB99B0', //acesta este fisierul FINAL REAL
        );

        return isset($config[$this->list_id]) ? $config[$this->list_id] : 'no_access';
    }


    private function getAllowedMethods() {
        return array(
            WI_Subscriber_Service_Config::SERVICE_METHOD_COUNT,
            WI_Subscriber_Service_Config::SERVICE_METHOD_COUNT_UNSUBSCRIBERS,
            WI_Subscriber_Service_Config::SERVICE_METHOD_SAVE,
            WI_Subscriber_Service_Config::SERVICE_METHOD_SELECT,
            WI_Subscriber_Service_Config::SERVICE_METHOD_SELECT_ONE,
            WI_Subscriber_Service_Config::SERVICE_METHOD_UPDATE,
            WI_Subscriber_Service_Config::SERVICE_METHOD_UNSUBSCRIBE,
            WI_Subscriber_Service_Config::SERVICE_METHOD_RESUBSCRIBE,
            WI_Subscriber_Service_Config::SERVICE_METHOD_APPEND,
            WI_Subscriber_Service_Config::SERVICE_METHOD_MOBILE_SAVE,
            WI_Subscriber_Service_Config::SERVICE_METHOD_ANONYMIZE,
            WI_Subscriber_Service_Config::SERVICE_METHOD_TRIGGER_LINK,
  	    WI_Subscriber_Service_Config::SERVICE_METHOD_CREATE_SEGMENT,
	    WI_Subscriber_Service_Config::SERVICE_METHOD_REPORT_BY_SEGMENT,
 	    WI_Subscriber_Service_Config::SERVICE_METHOD_REPORT_BY_LIST
        );
    }


    public function validateMethod() {
        if (empty($this->request['method'])) {
            throw(new Exception('No method!'));
        }

        if ( empty($this->request['wlm_use_direct_save'])
            && !in_array($this->request['method'], $this->getAllowedMethods()) ) {
            throw(new Exception('Method unknown!'));
        }

        if (($this->request['method'] == WI_Subscriber_Service_Config::SERVICE_METHOD_SELECT
            || $this->request['method'] == WI_Subscriber_Service_Config::SERVICE_METHOD_SELECT_ONE)
            && in_array($this->list_id, $this->not_allowed_to_use_select)) {
            throw(new Exception('Method not allowed!'));
        }



    }

    public function validateReturnDataTypeDependencies($return_data_type) {
        $this->has_callback = false;

        if ($return_data_type == WI_Subscriber_Service_Config::SERVICE_RETURN_DATA_TYPE_JSONP) {
            if (empty($this->request['return_callback'])) {
                throw(new Exception('No return_callback!'));
            }
            
            $this->has_callback = true;
        }
    }


    public function validateMethodSelectDependencies() {
        if (!isset($this->request['offset'])) {
            throw(new Exception('No offset!'));
        }

        if (!isset($this->request['limit'])) {
            throw(new Exception('No limit!'));
        } else {
            if ($this->request['limit'] > 150) { // it was 50 before (09.02.2018) - modified for edenred (marketing) // modified 150 - 03.05.2018 - legrand
                throw(new Exception('Limit is bigger than 150!'));
            }
        }

        if (!empty($this->request['search'])) { // search[]=email|sorin@whiteimage.ro|5 -> field_name|field_value|field_operator
            if (!is_array($this->request['search'])) {
                throw(new Exception('Search field is not array! Use search[]= ...'));
            } else {
               foreach ($this->request['search'] as $val) {
                  $search_arr = explode('|', $val);

                   if (!isset($search_arr[0]) || !isset($search_arr[1]) || !isset($search_arr[2])) {
                       throw(new Exception('Search parameter values missing!'));
                   }
               }
            }
        }

        if (!empty($this->request['search_field']) && !isset($this->request['search_operator'])) {
            throw(new Exception('No operator for search!'));
        }
    }

    public function validateMethodDirectSaveDependencies() {
        if (!isset($this->request['fv'])) {
            throw(new Exception('Required parameter [fv] is missing!'));
        }

        if (!isset($this->request['dont_validate_email']) && empty($this->request['fv']['email'])) {
            throw(new Exception('Required parameter [email] is missing or is empty!'));
        }
    }
}
