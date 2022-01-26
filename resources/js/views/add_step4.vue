<template>
    <div id="app">
        <modal name="Step4Modal" :height="'auto'" :scrollable="true" :resizable="true">
            <b-form-group class="m-5" label="ハンドルネームを設定してください（削除時の照合に使います）">
                <b-form-input type="text" class="form-control" v-model="CreaterHN" placeholder="name"></b-form-input>
                <b-button size="lg" class="m-3" @click="submit">登録</b-button>
            </b-form-group>
        </modal>
    </div>
</template>
<script>
export default {
    props: ['InputTime','InputTitle','InputSwitch','InputIsAdd','InputCate','form','members','current_member'],
    data(){
        return{
            CreaterHN:"",
            TitleArray:[],
            StartArray:[],
            EndArray:[],
            CateArray:[],
            member_idArray:[],
            Datalength:0,
            SendArray:[]
        }
    },
    methods: {
        submit(){
            let Arraylength = this.InputTime.length
            for(let i = 0; i < Arraylength; i++){
                if(this.InputIsAdd[i] == true){
                    if(this.InputSwitch[i] == "end"){
                        if(this.InputIsAdd[i-1] == true){
                            let InputTimeTemp = this.InputTime[i]; 
                            let SetHMS = InputTimeTemp.split(':');
                            if(SetHMS.length == 2){
                                let TimeM = SetHMS[0]
                                let TimeS = SetHMS[1]
                                let Time = Number(TimeM)*60+Number(TimeS)
                                let arrayTemp = this.EndArray.splice(-1,1,Time)
                            }else{
                                let TimeH = SetHMS[0]
                                let TimeM = SetHMS[1]
                                let TimeS = SetHMS[2]
                                let Time = Number(TimeH)*3600+Number(TimeM)*60+Number(TimeS)
                                let arrayTemp = this.EndArray.splice(-1,1,Time)
                            }
                        }
                    }else{
                        this.TitleArray.push(this.InputTitle[i]);
                        this.EndArray.push(0);
                        this.CateArray.push(this.InputCate[i]);
                        this.Datalength++
                        
                        let InputTimeTemp = this.InputTime[i]; 
                        let SetHMS = InputTimeTemp.split(':');
                        if(SetHMS.length == 2){
                            let TimeM = SetHMS[0]
                            let TimeS = SetHMS[1]
                            let Time = Number(TimeM)*60+Number(TimeS)
                            this.StartArray.push(Time);
                        }else{
                            let TimeH = SetHMS[0]
                            let TimeM = SetHMS[1]
                            let TimeS = SetHMS[2]
                            let Time = Number(TimeH)*3600+Number(TimeM)*60+Number(TimeS)
                            this.StartArray.push(Time);
                        }
                    }
                }
            }
            let now = new Date()
            for(let l = 0; l < this.Datalength; l++){
                this.SendArray.push({title: this.TitleArray[l],date: this.form.Date,VideoID: this.form.VideoID,VideoTitle: this.form.Title,start: this.StartArray[l],end: this.EndArray[l],status: 0,cate_id: this.CateArray[l],member_id: this.current_member.id,CreaterHN: this.CreaterHN,created_at:new Date(),updated_at:new Date()})
            }
            var self = this;
             axios({
                method: 'post',
                url: '/api/'+this.$route.params.member+'/add',
                dataType: 'json',
                data: this.SendArray
            })
            .then(response => {
            console.log(response)
            self.$emit('from-child')
            })
            .catch(error => {
            console.log(error)
            })
        }
    }
}
</script>