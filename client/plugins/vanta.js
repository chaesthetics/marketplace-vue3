import * as THREE from 'three';
import VANTA from 'vanta';

export default defineNuxtPlugin(nuxtApp => {
  nuxtApp.provide('vanta', VANTA);
  nuxtApp.provide('three', THREE);
});
