/**
 * @file
 * @author Tomáš Chochola <tomaschochola@seznam.cz>
 * @copyright © 2025 Tomáš Chochola <tomaschochola@seznam.cz>
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomaschochola} GitHub Profile
 * @see {@link https://github.com/sponsors/tomaschochola} GitHub Sponsors
 */

import { PrettierConfig } from '@tomaschochola/ts-tooling-prettier-config';

// eslint-disable-next-line no-restricted-exports
export default PrettierConfig.compose(
  PrettierConfig.base(),
  PrettierConfig.pug(),
  PrettierConfig.ruby(),
  PrettierConfig.xml(),
);
