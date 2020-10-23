<?php
 
namespace App\Controller;
 
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="list_cart")
     */
    public function list(SessionInterface $session)
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $session->get('cart', [])
        ]);
    }
 
    /**
     * @Route("/cart/add/{slug}", name="add_cart")
     * @Route("/cart/del/{slug}", name="del_cart")
     */
    public function updateItem(Product $product, Request $request, SessionInterface $session)
    {
        if($request->isXmlHttpRequest() != true) {
            return new JsonResponse(['statut' => 'error', 'error' => 'Accès non autorisé.']);
        } 
        $cart = $session->get('cart', []);
        
        $id = $product->getId();
        if(empty($cart[$id])) {
            $cart[$id] = [
                'quantity'  => 0,
                'name'      => $product->getName(),
                'picture'   => $product->getPicture(),
                'price'     => $product->getPrice(),
                'slug'      => $product->getSlug(),
            ];
        }
        if($request->get('_route') == 'del_cart') {
            $cart[$id]['quantity'] -= abs(ceil($request->query->get('quantity',1)));
        } else {
            $cart[$id]['quantity'] += abs(ceil($request->query->get('quantity',1)));
        }
 
        if($cart[$id]['quantity'] <= 0) {
            unset($cart[$id]);
            $quantity = 0;
        } else {
            $quantity = $cart[$id]['quantity'];
        }
 
        $session->set('cart', $cart);
 
        return new JsonResponse([
            'statut'                => 'ok', 
            'nb_product'            => array_sum(array_column($cart,'quantity')),
            'current_slug'          => $product->getSlug(),
            'current_nb_product'    => $quantity,
            'current_product_ttc'   => $quantity*$product->getPrice()
        ]);
    }
 
    /**
     * @Route("/cart/remove/", name="remove_cart")
     */
    public function remove(Request $request, SessionInterface $session)
    {
        if($request->isXmlHttpRequest() != true) {
            return new JsonResponse(['statut' => 'error', 'error' => 'Accès non autorisé.']);
        } 
        
        $session->set('cart', []);
        return new JsonResponse(['statut' => 'ok', 'nb_product' => 0]);
    }
 
}
