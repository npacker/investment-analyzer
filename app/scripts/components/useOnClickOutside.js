import { useEffect } from 'react';

const useOnClickOutside = (ref, callback) => {
  useEffect(() => {
    const onClickHandleer = event => {
      if (ref.current && !ref.current.contains(event.target)) {
        callback(event);
      }
    }
    document.addEventListener('click', onClickHandleer);
    return () => document.removeEventListener('click', onClickHandleer);
  }, [ref, callback]);
};

export default useOnClickOutside;
