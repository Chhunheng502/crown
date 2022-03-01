<template>
    <div class="flex flex-wrap">
        <div class="w-full text-center">

            <button type="button" :class="popoverClass" ref="btnRef" v-on:click="togglePopover()">
                <slot name="btnText"> </slot>
            </button>
            <div ref="popoverRef" v-bind:class="{'hidden': !popoverShow, 'block': popoverShow}" class="bg-gray-500 border-0 p-1 mt-3 block z-50 font-normal leading-normal text-sm max-w-xs text-left no-underline break-words rounded-lg">
                <slot name="items"> </slot>

                <!-- <div>
                    <div class="bg-pink-600 text-white opacity-75 font-semibold p-3 mb-0 border-b border-solid border-blueGray-100 uppercase rounded-t-lg">
                        pink popover title
                    </div>
                    <div class="text-white p-3">
                        And here's some amazing content. It's very engaging. Right?
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>

import { createPopper } from "@popperjs/core";

export default {
  name: "top-pink-popover",

  props: ['popoverClass'],

  data() {
    return {
      popoverShow: false
    }
  },

  methods: {
    togglePopover: function(){
      if(this.popoverShow){
        this.popoverShow = false;
      } else {
        this.popoverShow = true;
        createPopper(this.$refs.btnRef, this.$refs.popoverRef, {
          placement: "bottom"
        });
      }
    }
  }
}
</script>