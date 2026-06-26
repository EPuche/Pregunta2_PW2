<?php

readonly class PreguntaDTO
{

    /**
     * @var mixed
     */
    public string $pregunta;
    /**
     * @var mixed
     */
    public int $opcionCorrecta;
    public string $categoria;
    public array $opciones;

    public function __construct(array $post) {
        $this->pregunta = $post['pregunta'] ?? '';
        $this->opcionCorrecta = (int)($post['opcionCorrecta'] ?? 0);
        $this->categoria = $post['categoria'];
        $this->opciones = [
            1 => $post['opcion1'] ?? '',
            2 => $post['opcion2'] ?? '',
            3 => $post['opcion3'] ?? '',
            4 => $post['opcion4'] ?? '',
        ];
    }
}