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
                <b-button v-if="isPaste == true" :pressed.sync="isPaste" variant="primary">このサイトで設定</b-button>
                <b-button v-else :pressed.sync="isPaste" variant="primary">貼り付けで取得</b-button>
            </div>
            <b-button class="m-1" v-if="isPaste == false" @click="getTime">現在位置を取得</b-button>
            
            <b-row class="my-3" align-v="center">
                <b-col>
                     <b-button size="sm" class="p-1" @click="SSMinus">-10秒</b-button>
                </b-col>
                <b-col>
                     <b-button size="sm" class="p-1" @click="SMinus">-1秒</b-button>
                </b-col>
                <b-col>
                    <b-button size="lg" class="p-1" @click="pauseVideo" v-if="playing">pause</b-button>
                    <b-button size="lg" class="p-1" @click="playVideo" v-else>play</b-button>
                </b-col>
                <b-col>
                     <b-button size="sm" class="p-1" @click="SPlus">+1秒</b-button>
                </b-col>
                <b-col>
                     <b-button size="sm" class="p-1" @click="SSPlus">+10秒</b-button>
                </b-col>
            </b-row>

            <b-row class="justify-content-md-center my-5" align-v="end">
                <b-col>
                     <b-button size="sm" @click="InputMinus">戻る</b-button>
                </b-col>
                <b-col cols="3">
                    <b-form-input v-model.number="PMInput" type="number"></b-form-input>
                </b-col>
                <b-col cols="1">
                    <p>秒</p>
                </b-col>
                <b-col>
                     <b-button size="sm" @click="InputPlus">進む</b-button>
                </b-col>
            </b-row>

            <b-row class="justify-content-md-center my-5" align-v="center">
                <b-col cols="4">
                    <p>入力された時間へ飛びます→</p>
                </b-col>
                <b-col cols="4">
                    <b-form-input v-model="SeekInput" type="text"></b-form-input>
                </b-col>
                <b-col>
                     <b-button size="sm" @click="InputSeek">SeekTo</b-button>
                </b-col>
            </b-row>

                <div v-if="isPaste == true">
                    <div>
                        <div class="mb-3">
                            <p>※「貼り付けで取得」を行うと登録データがリセットされます。</p>
                            <p>必ず、「貼り付けで取得」にて設定した後に「このサイトで取得」にて追加してください。</p>
                        </div>
                        <b-row class="justify-content-md-center mx-3" align-v="end">
                            <b-col>
                                <p>記入例</p>
                                <textarea rows="10" disabled>4:31:16\n32:00\n6:4:7\n6:09:08</textarea>
                            </b-col>
                            <b-col>
                                <textarea v-model="PastedTime" rows="15"></textarea>
                            </b-col>
                            <b-col>
                                <b-button class="m-3" @click="PasteToNow">変換</b-button>
                            </b-col>
                        </b-row>
                    </div>
                </div>

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
                            <b-form-input  size="sm" type="text" v-model="InputTime[index]" disabled></b-form-input>
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
                            <b-button  size="sm" type="button" @click="removeInput(index)">削除</b-button>
                        
                            <b-button  size="sm" type="button" @click="PlayAt(index)">SeekTo</b-button>
                        </b-col>
                    </b-row>
                </div>
            </b-card>
            <div>
                <b-button class="m-3" size="lg" @click="ShowStamp">タイムスタンプを出力</b-button>
            </div>
            <div>
                <b-button class="m-3" size="lg" @click="AddToDB">データ登録</b-button>
            </div>
            <div>
                <b-button @click="back">戻る</b-button>
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
                let InputTimeTemp = this.InputTime[index-1]; 
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
        },
        scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
        }
    }
</script>