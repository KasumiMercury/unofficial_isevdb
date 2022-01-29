<template>
	<div id="app">
        <div class="w-65 m-auto">
            <b-card>
                <b-aspect aspect="16:9">
                    <youtube :video-id="form.VideoID" ref="youtube" ></youtube>
                </b-aspect>
            </b-card>
        </div>
        <div class="w-100">
            <div class="m-3">
                <b-button v-if="isPaste == true" :pressed.sync="isPaste" variant="primary"><i class="fas fa-search-plus"></i> このサイトで設定</b-button>
                <b-button v-else :pressed.sync="isPaste" variant="primary"><i class="fas fa-paste"></i> 貼り付けで取得</b-button>
            </div>
            <div>
            <b-button class="m-1" size="lg" v-if="isPaste == false" @click="getTime"><i class="fas fa-search-plus"></i> 現在位置を取得</b-button>
            </div>

            <div class="mt-3">
            <b-button-group size="lg">   
                <b-button class="p-1" @click="SSMinus"><i class="fas fa-angle-double-left"></i>　10秒</b-button>
                <b-button class="p-1" @click="SMinus"><i class="fas fa-angle-left"></i>　1秒</b-button>
                <b-button size="lg" class="p-1" @click="pauseVideo" v-if="playing"><i class="fas fa-pause fa-fw"></i>PAUSE</b-button>
                <b-button size="lg" class="p-1" @click="playVideo" v-else><i class="fas fa-play fa-fw"></i>PLAY</b-button>
                <b-button class="p-1" @click="SPlus"><i class="fas fa-angle-right"></i>　1秒</b-button>
                <b-button class="p-1" @click="SSPlus"><i class="fas fa-angle-double-right"></i>　10秒</b-button>
            </b-button-group>
            </div>

            <b-row class="justify-content-md-center my-5" align-v="end">
                <b-col  col lg="2">
                     <b-button size="lg" @click="InputMinus"><i class="fas fa-caret-left"></i>　戻る</b-button>
                </b-col>
                <b-col cols="12" md="auto">
                    <b-form-spinbutton id="PMinput" size="lg" v-model.number="PMInput" min="1" max="10000" inline></b-form-spinbutton>
                    <label for="PMinput">秒</label>
                </b-col>
                <b-col col lg="2">
                     <b-button size="lg" @click="InputPlus">進む　<i class="fas fa-caret-right"></i></b-button>
                </b-col>
            </b-row>

            <b-row class="justify-content-md-center my-5" align-v="center">
                <b-col cols="12" md="auto">
                    <label for="SeekInput">入力された時間へ飛びます：</label>
                </b-col>
                <b-col col lg="2">
                    <b-form-input id="SeekInput" v-model="SeekInput" type="text"></b-form-input>
                </b-col>
                <b-col col lg="2">
                     <b-button @click="InputSeek"><i class="fas fa-forward"></i>　SeekTo</b-button>
                </b-col>
            </b-row>

                <div v-if="isPaste == true">
                    <div>
                        <div class="mb-3">
                            <p>※「貼り付けで取得」を行うと登録データがリセットされます。</p>
                            <p>必ず、「貼り付けで取得」にて設定した後に「このサイトで取得」にて追加してください。</p>
                        </div>
                        <b-row class="justify-content-md-center mx-3" align-v="end">
                            <b-col cols="12" md="auto">
                                <p>記入例</p>
                                <textarea rows="10" disabled>4:31:16&#13;&#10;32:00&#13;&#10;6:4:7&#13;&#10;6:09:08</textarea>
                            </b-col>
                            <b-col cols="12" md="auto">
                                <textarea v-model="PastedTime" rows="15"></textarea>
                            </b-col>
                            <b-col cols="12" md="auto">
                                <b-button class="m-3" @click="PasteToNow">変換</b-button>
                            </b-col>
                        </b-row>
                    </div>
                </div>
            <b-card>
                <div>
                    <h5 class="m-3" style="color: #0086A2;"><i class="fas fa-check-circle"></i>「現在時刻を取得」または「貼り付けから取得」→「変換」で時刻を取得してください。</h5>
                    <h5 class="m-3" style="color: #0086A2;"><i class="fas fa-check-circle"></i>　Start/Endを選択してください。デフォルトはStartです。</h5>
                    <p>Endに設定されたデータはDB登録時に終了時刻として使用されます。</p>
                    <p>End設定はなくても登録できます。その場合は最後まで再生されます。</p>
                    <p>タイムスタンプにはStartで設定されている時刻のみ反映されます。</p>
                    <h5 class="m-3" style="color: #0086A2;"><i class="fas fa-check-circle"></i>　タイトルを入力してください。</h5>
                    <p>DB登録時やタイムスタンプに反映されます。</p>
                    <h5 class="m-3" style="color: #0086A2;"><i class="fas fa-check-circle"></i>　カテゴリーを選択してください。</h5>
                    <p>タイムスタンプ用のデータはカテゴリー選択を無視しても影響はありません。</p>
                    <h5 class="m-3" style="color: #0086A2;"><i class="fas fa-check-circle"></i>「DBに追加」のチェックを外すとDB登録時に除外されます。</h5>
                    <p>タイムスタンプ用のみの時刻はチェックを外してください。</p>
                </div>
            </b-card>
            <b-card class="w-100">
                <div class="w-100 my-5" v-for="(time,index) in this.InputTime" :key="'time'+index">
                    <b-row align-v="center">
                        <b-col sm="1"  class="my-1">
                            <template v-if="index != 0">
                                <b-button size="sm" @click="UpCol(index)">&#9650;</b-button>
                            </template>
                            <template v-if="index != Collength-1">
                                <b-button size="sm" @click="DownCol(index)">&#9660;</b-button>
                            </template>
                        </b-col>
                        <b-col sm="1"  class="my-1">
                            <b-form-input  size="sm" type="text" v-model="InputTime[index]"></b-form-input>
                        </b-col>
                        <b-col sm="1"  class="my-1">
                            <div v-if="InputSwitch[index-1] == 'end'">
                                <select v-model="InputSwitch[index]" class="form-select form-select-sm" disabled>
                                    <option value="start">Start</option>
                                </select>
                            </div>
                            <div v-else>
                                <select v-model="InputSwitch[index]" class="form-select form-select-sm">
                                    <option value="start">Start</option>
                                    <option value="end">End</option>
                                </select>
                            </div>
                        </b-col>
                        <b-col sm="4" class="my-1">
                            <b-form-input v-if="InputSwitch[index] == 'end'" size="sm" type="text" placeholder="タイトル" v-model="InputTitle[index]" disabled></b-form-input>
                            <b-form-input v-else size="sm" type="text" placeholder="タイトル" v-model="InputTitle[index]"></b-form-input>
                        </b-col>
                         <b-col sm="1" class="my-1">
                            <b-form-select size="sm" v-if="InputSwitch[index] == 'end'" v-model="InputCate[index]" :options="options" disabled></b-form-select>
                            <b-form-select size="sm" v-else v-model="InputCate[index]" :options="options"></b-form-select>
                        </b-col>
                         <b-col sm="2" class="my-1" >
                            <input type="checkbox" id="IsAdd" v-model="InputIsAdd[index]">
                            <label for="IsAdd">DBに追加</label>
                        </b-col>
                        <b-col lg="2" class="my-1">
                            <b-button  size="sm" type="button" @click="removeInput(index)"><i class="fas fa-minus-circle"></i>削除</b-button>
                        
                            <b-button  size="sm" type="button" @click="PlayAt(index)"><i class="fas fa-forward"></i>SeekTo</b-button>
                        </b-col>
                    </b-row>
                </div>
            </b-card>
            <div>
                <b-button class="m-3" size="lg" @click="ShowStamp"><i class="fas fa-file-export"></i>　タイムスタンプを出力</b-button>
            </div>
            <div>
                <b-button class="m-3" size="lg" @click="AddToDB"><i class="fas fa-cloud-upload-alt"></i>　データ登録</b-button>
            </div>
            <div>
                <b-button @click="back"><i class="fas fa-arrow-circle-left"></i>　戻る</b-button>
            </div>


                <div class="invisible">
                    <textarea v-model="NowTime" rows="1" id="log"></textarea>
                    <textarea v-model="AddedTime" rows="1"></textarea>
                </div>
        </div>
        
            <StampModal :InputTitle="this.InputTitle" :InputTime="InputTime" :InputSwitch="InputSwitch" v-on:from-child="HideStamp">
            </StampModal>
            <Step4Modal :form="form" :InputTitle="this.InputTitle" :InputTime="InputTime" :InputSwitch="InputSwitch" :InputIsAdd="InputIsAdd" :InputCate="InputCate" :current_member="current_member" v-on:from-child="HideStep4"></Step4Modal>
         <modal name="completed" class="text-center">
            <div class="my-5">
                <p>送信完了しました！</p>
                <p>ご協力ありがとうございます！</p>
            </div>
            <b-button class="m-3" v-on:click="$router.push('/'+current_member.name+'/1')">トップへ</b-button>
            <b-button class="m-3" @click="hidecomp">閉じる</b-button>
        </modal>
    </div>
</template>

<script>
import StampModal from './stamp_modal.vue'
import Step4Modal from './add_step4.vue'
    export default {
        props:['form','categories','current_member'],
        data(){
            return{
                playing: false,
                NowTime:"",
                time:"",
                INTtime:"",
                HMStime:"",
                tmp:"",
                PastedTime:"",
                AddedTime:"",
                InputTime:[],
                InputSwitch:[],
                InputIsAdd:[],
                InputTitle:[],
                InputCate:[],
                isPaste: false,
                PMInput: 5,
                SeekInput: "5:04",
                Collength: 0,
                options: new Object
            }
        },
        created(){
            let categoriesID = this.categories.map(item => item.id)
            let categoriesNAME = this.categories.map(item => item.title)
            let TempArray = []
            for(let i = 0; i < categoriesID.length; i++){
                TempArray.push({value: categoriesID[i],text: categoriesNAME[i]})
            }
            console.log(TempArray)
            this.options = TempArray
            console.log(TempArray)
            console.log(this.options)
        },
        methods:{
            playVideo(){ 
                this.player.playVideo()
                this.playing = true
            },
            pauseVideo(){ 
                this.player.pauseVideo()
                this.playing = false
            },
            getTime(){
                this.player.getCurrentTime().then((time) => {
                    this.INTtime = Math.floor(time)
                    let hour = Math.floor(this.INTtime / 3600);
                    let min = Math.floor(this.INTtime % 3600 / 60);
                    let rem = this.INTtime % 60;
                    this.HMStime = hour+':'+min+':'+rem ; 

                    this.NowTime = this.tmp
                    this.NowTime = this.tmp += this.HMStime+'\n'

                    let TimeArrayRaw = this.NowTime.split('\n');
                    var TimeArrayTemp = TimeArrayRaw.pop();
                    var AddedTimeArray = TimeArrayRaw[TimeArrayRaw.length - 1]
                    let NowTimeArrayTemp = this.InputTime.filter(v => v)
                    var NowTimeArray = NowTimeArrayTemp.concat(AddedTimeArray);
                    this.InputTime = NowTimeArray.filter(v => v)
                    this.Collength = this.Collength+1
                    this.InputCate.push(1)
                    this.InputSwitch.push('start')
                    this.InputIsAdd.push(true)
                });
            },
            removeInput(index) {
                console.log(this.InputTime.length)
                let InputTimeTemp = this.InputTime.splice(index, 1);
                let InputTitleTemp = this.InputTitle.splice(index, 1);
                let InputCateTemp = this.InputCate.splice(index, 1);
                let InputSwitchTemp = this.InputSwitch.splice(index, 1);
                let InputIsAddTemp = this.InputIsAdd.splice(index, 1);
                this.Collength = this.Collength-1 
                console.log(this.Collength)
                console.log(this.InputTitle)
                console.log(this.InputTime)
            },
            PasteToNow(){
                let PastedArrayRaw = this.PastedTime.split('\n');
                console.log(PastedArrayRaw)
                this.InputTime = PastedArrayRaw.filter(v => v)
                let numTemp = this.InputTime.length
                for(let i = 0; i < numTemp; i++){
                    this.InputCate.push(1)
                    this.InputSwitch.push('start')
                    this.InputIsAdd.push(true)
                }
                this.Collength = this.Collength + numTemp
            },
            PlayAt(index){
                let InputTimeTemp = this.InputTime[index]; 
                let SetHMS = InputTimeTemp.split(':');
                console.log(SetHMS);
                if(SetHMS.length == 2){
                    let TimeM = SetHMS[0]
                    let TimeS = SetHMS[1]
                    let SeekTime = Number(TimeM)*60+Number(TimeS)
                    this.player.seekTo(SeekTime,true);
                }else{
                    let TimeH = SetHMS[0]
                    let TimeM = SetHMS[1]
                    let TimeS = SetHMS[2]
                    let SeekTime = Number(TimeH)*3600+Number(TimeM)*60+Number(TimeS)
                    this.player.seekTo(SeekTime,true);
                }
            },
            SSPlus(){
                this.player.getCurrentTime().then((time) => {
                    this.player.seekTo(time+10,true);
                });
            },
            SSMinus(){
                this.player.getCurrentTime().then((time) => {
                    this.player.seekTo(time-10,true);
                });
            },
            SPlus(){
                this.player.getCurrentTime().then((time) => {
                    this.player.seekTo(time+1,true);
                });
            },
            SMinus(){
                this.player.getCurrentTime().then((time) => {
                    this.player.seekTo(time-1,true);
                });
            },
            InputMinus(){
                console.log(this.PMInput)
                this.player.getCurrentTime().then((time) => {
                    this.player.seekTo(time-this.PMInput,true);
                });
            },
            InputPlus(){
                console.log(this.PMInput)
                this.player.getCurrentTime().then((time) => {
                    this.player.seekTo(time+this.PMInput,true);
                });
            },
            InputSeek(){
                let InputTimeTemp = this.SeekInput; 
                let SetHMS = InputTimeTemp.split(':');
                console.log(SetHMS);
                if(SetHMS.length == 2){
                    let TimeM = SetHMS[0]
                    let TimeS = SetHMS[1]
                    let SeekTime = Number(TimeM)*60+Number(TimeS)
                    this.player.seekTo(SeekTime,true);
                }else{
                    let TimeH = SetHMS[0]
                    let TimeM = SetHMS[1]
                    let TimeS = SetHMS[2]
                    let SeekTime = Number(TimeH)*3600+Number(TimeM)*60+Number(TimeS)
                    this.player.seekTo(SeekTime,true);
                }
            },
            ShowStamp(){
                this.$modal.show('stamp-modal');
            },
            HideStamp(){
                this.$modal.hide('stamp-modal')
            },
            UpCol(index){
                let TempTimeNow = this.InputTime[index]
                let TempTimeAbove = this.InputTime[index-1]
                let indexTemp = index-1
                this.InputTime.splice(indexTemp, 2,TempTimeNow,TempTimeAbove);
                
                let TempTitleNow = this.InputTitle[index]
                let TempTitleAbove = this.InputTitle[index-1]
                this.InputTitle.splice(indexTemp, 2,TempTitleNow,TempTitleAbove)
                console.log(this.InputTitle)
            },
            DownCol(index){
                let TempTimeNow = this.InputTime[index]
                let TempTimeBelow = this.InputTime[index+1]
                let TempTitleNow = this.InputTitle[index]
                let TempTitleBelow = this.InputTitle[index+1]

                this.InputTime.splice(index, 2,TempTimeBelow, TempTimeNow);
                this.InputTitle.splice(index, 2,TempTitleBelow,TempTitleNow);
            },
            AddToDB(){
                this.$modal.show('Step4Modal')
            },
            back() {
                this.$emit('from-child2')
		    },
            HideStep4(){
                this.$modal.hide('Step4Modal')
                this.$modal.show('completed');
            },
            hidecomp(){
                this.$modal.hide('completed');
            }
        },
        computed:{
            player(){
                return this.$refs.youtube.player
            },
        },
        components: {
            StampModal,
            Step4Modal,
        }
    }
</script>