

import {ref} from 'vue';

export default function useProgress() {
  let time = 0;
  let working = true;
  let generator: Generator<number>;
  const frequency = 100;
  const progress = ref(0);

  function* exponentGenerator() {
    const _progress = 0;
    while (_progress < 1) {
      // simplified implementation from https://github.com/piercus/fake-progress
      yield 1 - Math.exp((-1 * time) / 1000);
      time += frequency;
    }
  }

  const increment = () => {
    setTimeout(() => {
      if (progress.value === 100 || !working) return;
      // to prevent progress.value reaching 100 prematurely
      if (progress.value < 99) {
        progress.value = generator.next().value * 100;
      }
      increment();
    }, frequency + Math.random() * 500);
  };

  const start = () => {
    time = 0;
    working = true;
    progress.value = 0;
    generator = exponentGenerator();
    increment();
  };

  const end = () => {
    progress.value = 100;
  };

  const stop = () => {
    working = false;
  };

  return {
    end,
    stop,
    start,
    progress,
  };
}
