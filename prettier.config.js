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

import { PrettierStack } from '@premierstacks/prettier-stack';

// eslint-disable-next-line no-restricted-exports
export default PrettierStack.create()
  .base()
  .pug()
  .ruby()
  .xml()
  .build();
