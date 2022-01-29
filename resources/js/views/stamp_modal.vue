<template>
    <div id="app">
        <modal name="stamp-modal" :width="'70%'" :height="'auto'" :scrollable="true" :resizable="true">
            <b-button size="lg" class="m-3" @click="CopyStamp"><i class="fas fa-clipboard"></i>　コピー</b-button>
            <b-card>
                <div class="text-center" id="target">
                    <ul style="list-style-type: none;" class="text-center"  v-for="(time,index) in InputTime" :key="index">
                        <li v-if="InputSwitch[index] != 'end'">{{InputTime[index]}} {{InputTitle[index]}} <span style=" display: none;">\n</span></li>
                    </ul>
                </div>
            </b-card>
        </modal>
    </div>
</template>
<script>
export default {
    props: ['InputTime','InputTitle','InputSwitch'],
    data(){
        return{
            stamp: ""
        }
    },
    methods: {
    CopyStamp() {
        var self = this;
        const copyText = this.$el.querySelector('#target').innerText
        navigator.clipboard
        .writeText(copyText)
        .then(() => {
          alert('コピーしました！')
          self.$emit('from-child')
        })
        .catch(e => {
          alert(e)
        })
    }
    }
}
</script>