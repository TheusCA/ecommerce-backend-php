
CREATE TABLE `category` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Adicionar coluna `category_id` na tabela `prod`
--
ALTER TABLE `prod`
ADD COLUMN `category_id` INT(11) NULL AFTER `preco`;

ALTER TABLE `prod`
ADD CONSTRAINT `fk_category`
FOREIGN KEY (`category_id`)
REFERENCES `category`(`id`)
ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;
