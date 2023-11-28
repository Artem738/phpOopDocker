<?php
//
//namespace AppOld\Core\Di;
//
//use App\Core\Exeptions\ContainerException;
//use App\Core\Exeptions\NotFoundException;
//use Psr\Container\ContainerInterface;
//
//
//class Container_Old implements ContainerInterface
//{
//    /**
//     * @var callable[] Асоціативний масив, де ключ - це ім'я абстрактного визначення,
//     * а значення - це конкретна функція, яка повертає об'єкт даного визначення.
//     */
//    private array $bindings = [];
//
//    /**
//     * Зв'язує абстрактне визначення із конкретною реалізацією.
//     *
//     * @param string $abstract Абстрактне визначення - назва або ключ сервісу.
//     * @param callable $concrete Конкретна реалізація - це функція, яка при виклику повертає об'єкт сервісу.
//     */
//    public function bind(string $abstract, callable $concrete): void
//    {
//        $this->bindings[$abstract] = $concrete;
//    }
//
//    /**
//     * Отримує сервіс з контейнера.
//     *
//     * @param string $id Ідентифікатор сервісу для отримання.
//     * @return mixed Сервіс.
//     *
//     * @throws NotFoundException Якщо сервіс із зазначеним ID-im'ям відсутній у контейнері.
//     * @throws ContainerException При виникненні будь-якої помилки під час створення сервісу.
//     */
//    public function get(string $id): mixed
//    {
//        if (!$this->has($id)) {
//            throw new NotFoundException("Невідоме зв'язування: $id");
//        }
//
//        try {
//            return $this->bindings[$id]();
//        } catch (\Exception $e) {
//            throw new ContainerException($e->getMessage(), 0, $e);
//        }
//    }
//
//    /**
//     * Перевіряє, чи існує сервіс у контейнері.
//     *
//     * @param string $id Ідентифікатор сервісу для перевірки.
//     * @return bool True, якщо сервіс існує в контейнері, false - в іншому випадку.
//     */
//    public function has(string $id): bool
//    {
//        return isset($this->bindings[$id]);
//    }
//
//    // наступного разу - Symfony Dependency Injection чи PHP-DI ...
//}
