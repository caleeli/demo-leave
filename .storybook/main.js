/** @type { import('@storybook/vue-vite').StorybookConfig } */
const config = {
  stories: [
    "../stories/**/*.mdx",
    "../stories/**/*.stories.@(js|jsx|mjs|ts|tsx)",
    "../resources/js/**/*.stories.@(js|jsx|mjs|ts|tsx)",
  ],
  addons: [
    "@storybook/addon-links",
    "@storybook/addon-essentials",
    "@storybook/addon-docs",
    "@storybook/addon-interactions",
    'storybook-addon-mock',
  ],
  framework: {
    name: "@storybook/vue-vite",
    options: {}
  },
  async viteFinal(config) {
    const { resolve, dirname } = await import('path');
    const { fileURLToPath } = await import('url');
    const storybookDir = dirname(fileURLToPath(import.meta.url));
    config.resolve = config.resolve || {};
    config.resolve.alias = [
      ...(Array.isArray(config.resolve.alias) ? config.resolve.alias : []),
      { find: '@', replacement: resolve(storybookDir, '../resources/js') },
    ];
    return config;
  },
  docs: {
    autodocs: "tag"
  }
};
export default config;
