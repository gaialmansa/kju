<?php
/*
  Zerfrex (R) RAD ADM
  Zerfrex RAD for Administration & Data Management

  Copyright (c) 2013-2022 by Jorge A. Montes Pérez <jorge@zerfrex.com>
  All rights reserved. Todos los derechos reservados.

  Este software solo se puede usar bajo licencia del autor.
  El uso de este software no implica ni otorga la adquisición de
  derechos de explotación ni de propiedad intelectual o industrial.
 */

/**
 * @var string $attrData
 */
/**
 * @var string $href
 */
/**
 * @var string $sortButtonClass
 */
/**
 * @var string $text
 */
/**
 * @var integer $pos
 */
?><a <?php echo $attrData; ?> href="<?php echo $href; ?>"
                              class="_sortButton <?php echo $sortButtonClass; ?>"><?php echo $text; ?></a><?php echo($pos > 1 ? "($pos)" : '');