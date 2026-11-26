<?php

namespace App\Compat;

/**
 * CodeIgniter 3 compatible shopping cart, stored in the session.
 */
class LegacyCart
{
    protected LegacySession $session;

    protected float $cartTotal = 0.0;

    protected int $cartTotalItems = 0;

    /** @var array<string, array<string, mixed>> */
    protected array $cartContents = [];

    public function __construct()
    {
        $session = Registry::get('lib:session') ?? Registry::get('session');

        if (! $session instanceof LegacySession) {
            $session = new LegacySession();
            Registry::set('session', $session);
            Registry::set('lib:session', $session);
        }

        $this->session = $session;

        $contents = $this->session->userdata('cart_contents');
        if (is_array($contents)) {
            $this->cartContents = $contents;
        }

        $this->_save_cart();
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function contents(): array
    {
        return $this->cartContents;
    }

    public function has_options(string $rowid = ''): bool
    {
        if (isset($this->cartContents[$rowid]['options']) && count((array) $this->cartContents[$rowid]['options']) > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param array<string, mixed> $items
     *
     * @return string|false
     */
    public function insert($items = [])
    {
        if (! is_array($items) || $items === []) {
            return false;
        }

        if (! isset($items[0]) || ! is_array($items[0])) {
            $items = [$items];
        }

        foreach ($items as $item) {
            if (! is_array($item) || ! isset($item['id'])) {
                continue;
            }

            $saveCart = false;
            $rowid    = $this->_insert($item);
            $oldQty   = $this->cartContents[$rowid]['qty'] ?? 0;

            if (isset($item['qty'])) {
                if ($item['qty'] == 0) {
                    unset($this->cartContents[$rowid]);
                } else {
                    $this->cartContents[$rowid]['qty'] = (float) $item['qty'];
                }
                $saveCart = true;
            } else {
                if (isset($this->cartContents[$rowid])) {
                    $this->cartContents[$rowid]['qty'] = $oldQty + (isset($this->cartContents[$rowid]['qty']) ? 1 : 0);
                }
                $saveCart = isset($this->cartContents[$rowid]);
            }

            unset($this->cartContents[$rowid]['old_qty']);

            if ($saveCart) {
                $this->_save_cart();
            }
        }

        return $rowid ?? false;
    }

    /**
     * @param array<string, mixed> $items
     */
    public function update($items = []): bool
    {
        if (! is_array($items) || $items === []) {
            return false;
        }

        $saveCart = false;

        foreach ($items as $items_array) {
            if (! is_array($items_array)) {
                continue;
            }

            foreach ($items_array as $key => $value) {
                if (! is_string($key) && ! is_int($key)) {
                    continue;
                }
            }

            $rowid = $items_array['rowid'] ?? '';
            if ($rowid === '' || ! isset($this->cartContents[$rowid])) {
                continue;
            }

            if (! isset($items_array['qty']) || $items_array['qty'] == 0) {
                unset($this->cartContents[$rowid]);
                $saveCart = true;
                continue;
            }

            if ($items_array['qty'] <= 0) {
                unset($this->cartContents[$rowid]);
                $saveCart = true;
                continue;
            }

            $this->cartContents[$rowid]['qty'] = (float) $items_array['qty'];

            if (isset($this->cartContents[$rowid]['price'])) {
                $this->cartContents[$rowid]['subtotal'] = $this->cartContents[$rowid]['price'] * $this->cartContents[$rowid]['qty'];
            }

            $saveCart = true;
        }

        if ($saveCart) {
            $this->_save_cart();
        }

        return true;
    }

    public function remove(string $rowid): bool
    {
        unset($this->cartContents[$rowid]);
        $this->_save_cart();

        return true;
    }

    public function destroy(): void
    {
        $this->cartContents = [];
        $this->session->unset_userdata('cart_contents');
        $this->cartTotal      = 0.0;
        $this->cartTotalItems = 0;
    }

    public function total(): float
    {
        return (float) $this->cartTotal;
    }

    public function total_items(): int
    {
        return $this->cartTotalItems;
    }

    /**
     * @return array<string, mixed>
     */
    public function product_options(string $rowid): array
    {
        return (array) ($this->cartContents[$rowid]['options'] ?? []);
    }

    /**
     * @param array<string, mixed> $item
     */
    protected function _insert($item): string
    {
        $rowid = md5(($item['id'] ?? '') . serialize($item['options'] ?? []));

        if (! isset($this->cartContents[$rowid])) {
            $this->cartContents[$rowid] = [
                'rowid'    => $rowid,
                'id'       => $item['id'] ?? '',
                'qty'      => 0,
                'price'    => (float) ($item['price'] ?? 0),
                'name'     => $item['name'] ?? '',
                'subtotal' => 0.0,
            ];

            foreach ($item as $key => $value) {
                if (! array_key_exists($key, $this->cartContents[$rowid])) {
                    $this->cartContents[$rowid][$key] = $value;
                }
            }
        }

        return $rowid;
    }

    protected function _save_cart(): void
    {
        $total      = 0.0;
        $totalItems = 0;

        foreach ($this->cartContents as $key => $val) {
            $qty   = (float) ($val['qty'] ?? 0);
            $price = (float) ($val['price'] ?? 0);

            $this->cartContents[$key]['subtotal'] = $price * $qty;
            $total += $this->cartContents[$key]['subtotal'];
            $totalItems += (int) $qty;
        }

        $this->cartTotal      = $total;
        $this->cartTotalItems = $totalItems;

        $this->session->set_userdata('cart_contents', $this->cartContents);
    }
}
