<template>
  <div>
    <fieldset
      :disabled="disabled"
      :class="['k-toggles-input', $attrs.class]"
      :style="$attrs.style"
    >
      <legend class="sr-only">{{ $t("options") }}</legend>

      <k-input-validator :required="required" :value="JSON.stringify(value)">
        <ul
          :data-labels="labels"
          :data-hasimages="hasImages"
          :style="{ '--options': columns ?? options.length }"
        >
          <li
            v-for="(option, index) in options"
            :key="index"
            :data-disabled="disabled"
          >
            <input
              :id="id + '-' + index"
              :aria-label="option.text"
              :disabled="disabled"
              :value="option.value"
              :name="id"
              :checked="value === option.value"
              class="input-hidden"
              type="radio"
              @click="onClick(option.value)"
              @change="onInput(option.value)"
            />

            <!-- Add style to label -->
            <label
              :for="id + '-' + index"
              :title="option.text"
              :style="{
                padding: 'var(--spacing-' + images.spacing + ')',
                color: option.color ?? '#fff',
                background: option.background ?? '#000',
              }"
            >
              <div
                v-if="hasImages"
                class="k-toggles-image-wrapper"
                :style="{
                  aspectRatio: images.ratio,
                  background: images.background,
                }"
              >
                <img
                  v-if="option.image"
                  class="k-toggles-image"
                  :src="option.image"
                  :style="{
                    objectFit: images.fit,
                    background: images.background,
                  }"
                />
              </div>
              <div v-if="images.caption" class="k-toggles-caption-wrapper">
                <k-icon v-if="option.icon" :type="option.icon" />
                <!-- eslint-disable vue/no-v-html -->
                <span
                  v-if="labels || !option.icon"
                  class="k-toggles-text"
                  v-html="option.text"
                />
                <!-- eslint-enable vue/no-v-html -->
              </div>
            </label>
          </li>
        </ul>
      </k-input-validator>
    </fieldset>
    <k-plain-license prefix="toggles" />
  </div>
</template>

<script>
export default {
  extends: "k-toggles-input",
  inheritAttrs: false,
  props: {
    hasImages: Boolean,
    license: {
      type: Object,
      default() {
        return null;
      },
    },
    images: {
      type: Object,
      default() {
        return {
          caption: Boolean,
          ratio: String,
          fit: String,
          spacing: 1,
          background: String,
        };
      },
    },
  },
};
</script>

<style type="sass">
.k-input-element k-input-validator > ul {
  display: flex;
  flex-wrap: wrap;
  input + label {
    position: relative;
  }
  > li {
    flex: 1 1 10rem;
    > input:checked + label {
      color: inherit;
      &:after {
        content: "";
        position: absolute;
        pointer-events: none;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border: 2px solid;
      }
    }
    .k-toggles-text {
      white-space: pre;
      max-width: 10em;
      text-overflow: ellipsis;
      overflow: hidden;
    }
    /*
    
    TODO: Find another solution cause multiple rows

    &:first-child > input + label:after {
      border-top-left-radius: var(--rounded);
      border-bottom-left-radius: var(--rounded);
    }

    &:last-child > input + label:after {
      border-top-right-radius: var(--rounded);
      border-bottom-right-radius: var(--rounded);
    }
    */
  }
  .k-toggles-caption-wrapper {
    display: flex;
    align-items: center;
  }

  .k-toggles-image-wrapper {
    position: relative;
    width: 100%;
    border: 1px solid var(--color-border);
    .k-toggles-image {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
    }
  }

  &[data-hasimages] {
    > li {
      height: auto;
    }
    label {
      flex-direction: column;
    }
    .k-toggles-caption-wrapper {
      padding: 0.4em 0 0.3em;
    }
  }
}
</style>
